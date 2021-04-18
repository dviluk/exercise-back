<?php

namespace App\Repositories\V1;

use App\Models\Workout;
use App\Repositories\Repository;
use App\Utils\ArrayUtils;
use DB;
use App\Enums\ManyToManyAction;

class WorkoutsRepository extends Repository
{
    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Workout::class;

    /**
     * Contiene los keys de los posibles valores del atributo $data
     * en el método `create` y `update`.
     * 
     * @param array $data
     * @param bool $updating Indica si el método se esta llamando desde `update`.
     * @return array
     */
    protected function availableInputKeys(array $data, bool $updating = false): array
    {
        return [
            'workout_id',
            'difficulty_id',
            'cover',
            'illustration',
            'name',
            'description',
            'muscles',
            'equipment',
        ];
    }

    /**
     * Valida si se puede crear un registro.
     * 
     * @param array $data 
     * @return void 
     */
    public function canCreate(array $data)
    {
        //
    }

    /**
     * Valida si se puede editar el registro.
     * 
     * @param Workout $item 
     * @param null|array $data 
     * @return void 
     */
    public function canUpdate($item, ?array $data = [])
    {
        //
    }

    /**
     * Valida si se puede eliminar el registro.
     * 
     * @param Workout $item 
     * @return void 
     */
    public function canDelete($item)
    {
        //
    }

    /**
     * Consulta todos los registros.
     *
     * @param array $options Las mismas opciones que en `Repository::prepareQuery($options)`
     * @return \Illuminate\Support\Collection|Workout[]
     * @throws \Error
     */
    public function all(array $options = [])
    {
        return parent::all($options);
    }

    /**
     * Busca un registro por ID.
     *
     * @param int $id
     * @param array $options Las mismas opciones que en `Repository::prepareQuery($options)`
     * @return null|Workout
     * @throws \Error
     */
    public function find($id, array $options = [])
    {
        return parent::find($id, $options);
    }

    /**
     * Busca un registro por ID, si no se encuentra se genera un error.
     *
     * @param int $id
     * @param array $options
     * @return Workout
     */
    public function findOrFail($id, array $options = [])
    {
        return parent::findOrFail($id, $options);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     * @return Workout
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $data = ArrayUtils::preserveKeys($data, $this->availableInputKeys($data));

            $muscles = $data['muscles'];
            $equipment = $data['equipment'];

            $data = ArrayUtils::omitKeys($data, [
                'muscles',
                'equipment',
            ]);

            $item = parent::create($data);

            $this->updateEquipment($item, ManyToManyAction::ATTACH(), $equipment);
            $this->updateMuscles($item, ManyToManyAction::ATTACH(), $muscles);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param int $id
     * @param array $data Contiene los campos a actualizar.
     * @param array $options
     * @return Workout
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $data = ArrayUtils::preserveKeys($data, $this->availableInputKeys($data, true));

            $muscles = $data['muscles'] ?? [];
            $equipment = $data['equipment'] ?? [];

            $data = ArrayUtils::omitKeys($data, [
                'muscles',
                'equipment',
            ]);

            $item = parent::update($id, $data, $options);

            $this->updateEquipment($item, ManyToManyAction::SYNC(), $equipment);
            $this->updateMuscles($item, ManyToManyAction::SYNC(), $muscles);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param int $id
     * @param array $options
     * @return Workout
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }

    /**
     * Actualiza los músculos asociados.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data 
     * 
     * attach|sync
     * 
     * - (string)   `data.*.id`: muscle id
     * - (bool)     `data.*.primary`
     * 
     * detach 
     * 
     * - (string)   `data.*`: muscle id.
     * 
     * @param array $options
     * 
     * - (bool) returnAttachedItems: Indica si se retornaran los items agregados.
     * 
     * @return Workout|\Illuminate\Support\Collection|\App\Models\Muscle[]
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function updateMuscles($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->muscles();

        $changes = $this->manyToManyActions($relation, $action, $data, false);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('muscle_id', $changes)->get();
        }

        return $item;
    }

    /**
     * Actualiza el equipo asociado.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data ids de los items
     * 
     * - (string) `data.*`: equipment id.
     * 
     * @param array $options
     * 
     * - (bool) returnAttachedItems: Indica si se retornaran los items agregados.
     * 
     * @return Workout|\Illuminate\Support\Collection|\App\Models\Equipment[]
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException 
     */
    public function updateEquipment($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->equipment();

        $changes = $this->manyToManyActions($relation, $action, $data);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('muscle_id', $changes)->get();
        }

        return $item;
    }
}
