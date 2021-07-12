<?php

namespace App\Repositories\V1;

use App\Enums\ManyToManyAction;
use DB;
use App\Models\Routine;
use App\Utils\ArrayUtils;
use App\Repositories\Repository;

class RoutinesRepository extends Repository
{
    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Routine::class;

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
            'name',
            'description',
            'workouts',
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
     * @param Routine $item 
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
     * @param Routine $item 
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
     * @return \Illuminate\Support\Collection|Routine[]
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
     * @return null|Routine
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
     * @return Routine
     */
    public function findOrFail($id, array $options = [])
    {
        return parent::findOrFail($id, $options);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     * @return Routine
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $data = ArrayUtils::preserveKeys($data, $this->availableInputKeys($data));

            $pivot = $data['workouts'];

            $data = ArrayUtils::omitKeys($data, ['workouts']);

            /** @var Routine */
            $item = parent::create($data);

            $this->updateWorkouts($item, ManyToManyAction::ATTACH(), $pivot);

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
     * @return Routine
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $data = ArrayUtils::preserveKeys($data, $this->availableInputKeys($data, true));

            $pivot = $data['workouts'] ?? [];
            $data = ArrayUtils::omitKeys($data, ['workouts']);

            /** @var Routine */
            $item = parent::update($id, $data, $options);

            $this->updateWorkouts($item, ManyToManyAction::SYNC(), $pivot);

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
     * @return Routine
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }

    /**
     * Actualiza los workouts asociados.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data 
     * 
     * attach|sync
     * 
     * - (string)   `data.*.id`: workout id
     * - (string)   `data.*.description` 
     * - (int)      `data.*.order` 
     * - (int)      `data.*.repetitions` 
     * - (int)      `data.*.quantity` 
     * - (string)   `data.*.quantity_unit_id` 
     * - (int)      `data.*.rest_time_between_repetitions` 
     * - (string)   `data.*.rest_time_after_workouts`
     * 
     * detach 
     * 
     * - (string) `data.*`: workout id.
     * 
     * @param array $options 
     * 
     * - (bool) returnAttachedItems: Indica si se retornaran los items agregados.
     * 
     * @return Routine|\Illuminate\Support\Collection|\App\Models\Workout[]
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \App\Utils\API\Error500 
     */
    public function updateWorkouts($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->workouts();

        $insertedIds = $this->manyToManyActions($relation, $action, $data, false);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('workout_id', $insertedIds)->get();
        }

        return $item;
    }
}
