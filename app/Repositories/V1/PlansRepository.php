<?php

namespace App\Repositories\V1;

use App\Enums\ManyToManyAction;
use App\Models\Plan;
use App\Repositories\Repository;
use App\Utils\ArrayUtils;
use DB;

class PlansRepository extends Repository
{
    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Plan::class;

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
            'difficulty_id',
            'introduction',
            'description',
            'instructions',
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
     * @param Plan $item 
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
     * @param Plan $item 
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
     * @return \Illuminate\Support\Collection|Plan[]
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
     * @return null|Plan
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
     * @return Plan
     */
    public function findOrFail($id, array $options = [])
    {
        return parent::findOrFail($id, $options);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     * @return Plan
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $routines = $data['routines'];
            $goals = $data['goals'];

            $data = ArrayUtils::omitKeys($data, [
                'routines',
                'goals'
            ]);

            /** @var Plan */
            $item = parent::create($data);

            $this->updateGoals($item, ManyToManyAction::ATTACH(), $goals);
            $this->updateRoutines($item, ManyToManyAction::ATTACH(), $routines);

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
     * @return Plan
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $routines = $data['routines'] ?? [];
            $goals = $data['goals'] ?? [];

            $data = ArrayUtils::omitKeys($data, [
                'routines',
                'goals'
            ]);

            /** @var Plan */
            $item = parent::update($id, $data, $options);

            $this->updateGoals($item, ManyToManyAction::SYNC(), $goals);
            $this->updateRoutines($item, ManyToManyAction::SYNC(), $routines);

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
     * @return Plan
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }

    /**
     * Actualiza los goals asociados.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data 
     * 
     * - (string)   `data.*` Id del goal
     * 
     * @param array $options 
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Plan 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \App\Utils\API\Error500 
     */
    public function updateGoals($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->goals();

        $changes = $this->manyToManyActions($relation, $action, $data);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('goal_id', $changes)->get();
        }

        return $item;
    }

    /**
     * Actualiza los goals asociados.
     * 
     * @param mixed $id 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data 
     * 
     * - (string)   `data.*` Id del goal
     * 
     * @param array $options 
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Plan 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \App\Utils\API\Error500 
     */
    public function updateRoutines($id, ManyToManyAction $action, array $data = [], array $options = [])
    {
        $item = $this->findOrFail($id);

        $relation = $item->routines();

        $changes = $this->manyToManyActions($relation, $action, $data);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('routine_id', $changes)->get();
        }

        return $item;
    }
}
