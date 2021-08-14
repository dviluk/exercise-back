<?php

namespace App\Repositories\V1;

use App\Enums\ManyToManyAction;
use App\Models\Exercise;
use App\Models\Plan;
use App\Models\ExerciseGroup;
use App\Repositories\Repository;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExerciseGroupsRepository extends Repository
{
    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = ExerciseGroup::class;

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
            'plan_id',
            'name',
            'description',
            'order',
            'exercises',
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
            'plan_id' => 'required|exists:' . Plan::class . ',id',
            'name' => 'required',
            'description' => 'nullable',
            'order' => 'required',
            'exercises' => 'nullable|array',
            'exercises.*.id' => 'exists:' . Exercise::class . ',id',
            'exercises.*.order' => 'nullable',
        ];

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
     * @param ExerciseGroup $item 
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
     * @param ExerciseGroup $item 
     * @return void 
     */
    public function canDelete($item)
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
     * @return \Illuminate\Support\Collection|ExerciseGroup[]
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
     * @return null|ExerciseGroup
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
     * @return ExerciseGroup
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
     * - Opcional
     * 
     * - (array)    `data.exercises`
     *      - (string)    `exercises.*.id`
     *      - (string)    `exercises.*.order`
     * 
     * @param array $options
     * @return ExerciseGroup
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        DB::beginTransaction();

        try {
            $exercises = $data['exercises'] ?? null;

            $item = parent::create($data, $options);

            $exerciseOptions = [
                'isArrayOfIds' => false,
            ];

            $this->updateExercises($item, $exercises, ManyToManyAction::ATTACH(), $exerciseOptions);

            DB::commit();

            return $item;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param int $id
     * @param array $data Contiene los campos a actualizar.
     *
     * - (string)   `data.name`
     * - (string)   `data.description`
     * 
     * - Opcional
     * 
     * - (array)    `data.exercises`
     *      - (string)    `exercises.*.id`
     *      - (string)    `exercises.*.order`
     * 
     * @param array $options
     * @return ExerciseGroup
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        DB::beginTransaction();

        try {
            $exercises = $data['exercises'] ?? null;

            $item = parent::update($id, $data, $options);

            $exerciseOptions = [
                'isArrayOfIds' => false,
            ];

            $this->updateExercises($item, $exercises, ManyToManyAction::SYNC(), $exerciseOptions);

            DB::commit();

            return $item;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param int $id
     * @param array $options
     * @return ExerciseGroup
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }

    /**
     * Actualiza los ejercicios del grupo.
     * 
     * @param mixed $id 
     * @param array $data 
     * 
     * - (string)    `data.*.id`
     * - (string)    `data.*.order`
     * 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $options 
     * @return mixed 
     * @throws \Error 
     * @throws \App\Utils\API\Error404 
     * @throws \InvalidArgumentException 
     * @throws \App\Utils\API\Error500 
     */
    public function updateExercises($id, array $data, ManyToManyAction $action, array $options = [])
    {
        return $this->defaultUpdateManyToManyRelation($id,  $action, $data, array_merge(
            $options,
            [
                'relationName' => 'exercises',
                'foreignKey' => 'exercise_id'
            ]
        ));
    }
}
