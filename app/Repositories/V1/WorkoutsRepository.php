<?php

namespace App\Repositories\V1;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\Workout;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
     * @param string $method Indica el método donde se esta llamando.
     * @param array $options
     * @return array
     */
    public function availableInputKeys(array $data, string $method, array $options = [])
    {
        return [
            'user_id',
            'user_plan_id',
            'workout_id',
            'plan_id',
            'sets',
            'repetitions',
            'rest',
            'time',
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
            'user_id' => 'required|exists:' . User::class . ',id',
            'user_plan_id' => 'required|exists:' . UserPlan::class . ',id',
            'workout_id' => 'required|exists:' . Workout::class . ',id',
            'plan_id' => 'required|exists:' . Plan::class . ',id',
            'sets' => 'required|numeric',
            'repetitions' => 'required|numeric',
            'rest' => 'required|numeric',
            'time' => 'required|numeric',
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
     * @param Workout $item 
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
     * @param Workout $item 
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
     *
     * - (string)   `data.exercise_id`
     * - (string)   `data.difficulty_id`
     * - (string)   `data.plan_id`
     * - (string)   `data.routine_id`
     * - (int)      `data.sets`
     * - (int)      `data.rest`
     * - (int)      `data.order`
     * - (int)      `data.min_repetitions`
     * - (int)      `data.max_repetitions`
     * 
     * @param array $options
     * @return Workout
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
     * - (string)   `data.exercise_id`
     * - (string)   `data.difficulty_id`
     * - (string)   `data.plan_id`
     * - (string)   `data.routine_id`
     * - (int)      `data.sets`
     * - (int)      `data.rest`
     * - (int)      `data.order`
     * - (int)      `data.min_repetitions`
     * - (int)      `data.max_repetitions`
     * 
     * @param array $options
     * @return Workout
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
     * @return Workout
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }
}
