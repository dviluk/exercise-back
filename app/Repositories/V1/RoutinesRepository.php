<?php

namespace App\Repositories\V1;

use App\Enums\ManyToManyAction;
use DB;
use App\Models\Routine;
use App\Models\Unit;
use App\Models\Workout;
use App\Repositories\Repository;
use Arrays;
use Illuminate\Http\Request;

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
     * @param string $method Indica el método donde se esta llamando.
     * @param array $options
     * @return array
     */
    protected function availableInputKeys(array $data, string $method, array $options = [])
    {
        return [
            'name',
            'description',
            'workouts',
        ];
    }

    /**
     * Reglas que se aplicaran a los inputs.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $method Indica el método donde se esta llamando.
     * @param mixed $id
     * @param array $options
     * @return array
     */
    public function inputRules(Request $request, string $method, $id = null, array $options = [])
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'workouts' => 'required|array|min:1',
            'workouts.*.id' => 'exists:' . Workout::class . ',id',
            'workouts.*.description' => 'nullable',
            'workouts.*.order' => 'integer',
            'workouts.*.repetitions' => 'integer',
            'workouts.*.quantity' => 'integer',
            'workouts.*.quantity_unit_id' => 'exists:' . Unit::class . ',id',
            'workouts.*.rest_time_between_repetitions' => 'integer',
            'workouts.*.rest_time_after_workout' => 'integer',
        ];

        if ($method === 'update') {
            $rules['workouts'] = str_replace('required', 'nullable', $rules['workouts']);
        }

        return $rules;
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
     * 
     * - (string)   `data.name`
     * - (string)   `data.description`
     * 
     * Opcionales
     * 
     * - (array)    `data.workouts`
     * 
     * @return Routine
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $data = Arrays::preserveKeys($data, $this->availableInputKeys($data, 'create'));

            $pivot = $data['workouts'] ?? [];

            $data = Arrays::omitKeys($data, ['workouts']);

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
            $data = Arrays::preserveKeys($data, $this->availableInputKeys($data, 'update'));

            $workouts = $data['workouts'] ?? null;
            $data = Arrays::omitKeys($data, [
                'workouts'
            ]);

            /** @var Routine */
            $item = parent::update($id, $data, $options);

            if (!is_null($workouts)) {
                $this->updateWorkouts($item, ManyToManyAction::SYNC(), $workouts);
            }

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

        $manyToManyOptions = [
            'isArrayOfIds' => false,
        ];

        $insertedIds = $this->manyToManyActions($relation, $action, $data, $manyToManyOptions);

        if (isset($options['returnAttachedItems'])) {
            return $relation->wherePivotIn('workout_id', $insertedIds)->get();
        }

        return $item;
    }
}
