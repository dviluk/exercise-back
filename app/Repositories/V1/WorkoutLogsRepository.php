<?php

namespace App\Repositories\V1;

use App\Models\Difficulty;
use App\Models\Exercise;
use App\Models\Plan;
use App\Models\Routine;
use App\Models\WorkoutLog;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WorkoutLogsRepository extends Repository
{
    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = WorkoutLog::class;

    /**
     * Contiene los keys de los posibles valores del atributo $data
     * en el método `create` y `update`.
     * 
     * @param array $data
     * @param string $method Indica el método donde se esta llamando.
     * @param array $options
     * @return array
     */
    public function availableInputKeys(array $data, string $method, array $options = [])
    {
        return [
            'exercise_id',
            'difficulty_id',
            'plan_id',
            'routine_id',
            'sets',
            'rest',
            'order',
            'min_repetitions',
            'max_repetitions',
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
            'exercise_id' => 'required|exists:' . Exercise::class . ',id',
            'difficulty_id' => 'required|exists:' . Difficulty::class . ',id',
            'plan_id' => 'required|exists:' . Plan::class . ',id',
            'routine_id' => 'required|exists:' . Routine::class . ',id',
            'sets' => 'required|numeric',
            'rest' => 'required|numeric',
            'order' => 'required|numeric',
            'min_repetitions' => 'required|numeric',
            'max_repetitions' => 'required|numeric',
        ];

        return $rules;
    }

    /**
     * Valida si se puede crear un registro.
     * 
     * @param array $data 
     * @return void 
     */
    public function canCreate(array $data, array $options = [])
    {
        //
    }

    /**
     * Valida si se puede editar el registro.
     * 
     * @param WorkoutLog $item 
     * @param null|array $data 
     * @return void 
     */
    public function canUpdate($item, ?array $data = [], array $options = [])
    {
        //
    }

    /**
     * Valida si se puede eliminar el registro.
     * 
     * @param WorkoutLog $item 
     * @return void 
     */
    public function canDelete($item, array $options = [])
    {
        //
    }

    /**
     * Permite encargarse de las opciones adicionales.
     *
     * @param Builder $builder
     * @param array $options
     * @return Builder
     */
    public function handleOptions(Builder $builder, array $options = [])
    {
        return $builder;
    }

    /**
     * Consulta todos los registros.
     *
     * @param array $options Las mismas opciones que en `Repository::prepareQuery($options)`
     * @return \Illuminate\Support\Collection|WorkoutLog[]
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
     * @return null|WorkoutLog
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
     * @return WorkoutLog
     */
    public function findOrFail($id, array $options = [])
    {
        return parent::findOrFail($id, $options);
    }

    /**
     * Crea un nuevo registr
     * - (string)   `data.user_id`
     * - (string)   `data.user_plan_id`
     * - (string)   `data.workout_id`
     * - (string)   `data.plan_id`
     * - (int)   `data.sets`
     * - (int)   `data.repetitions`
     * - (int)   `data.rest`
     * - (int)   `data.time`o.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     *
     * - (string)   `data.user_id`
     * - (string)   `data.user_plan_id`
     * - (string)   `data.workout_id`
     * - (string)   `data.plan_id`
     * - (int)   `data.sets`
     * - (int)   `data.repetitions`
     * - (int)   `data.rest`
     * - (int)   `data.time`
     * 
     * @param array $options
     * @return WorkoutLog
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        return parent::create($data);
    }

    /**
     * Actualiza un registro.
     *
     * @param int $id
     * @param array $data Contiene los campos a actualizar.
     *
     * - (string)   `data.user_id`
     * - (string)   `data.user_plan_id`
     * - (string)   `data.workout_id`
     * - (string)   `data.plan_id`
     * - (int)   `data.sets`
     * - (int)   `data.repetitions`
     * - (int)   `data.rest`
     * - (int)   `data.time`
     * 
     * @param array $options
     * @return WorkoutLog
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        return parent::update($id, $data, $options);
    }

    /**
     * Elimina un registro.
     *
     * @param int $id
     * @param array $options
     * @return WorkoutLog
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }
}
