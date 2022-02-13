<?php

namespace App\Repositories\V1;

use App\Enums\ManyToManyAction;
use App\Models\Difficulty;
use App\Models\Goal;
use App\Models\Plan;
use App\Repositories\Repository;
use App\Repositories\Traits\RepositoryUtils;
use Arrays;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PlansRepository extends Repository
{
    use RepositoryUtils;

    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Indica por que columna ordenar los resultados.
     * 
     * ['column', 'asc'|'desc', ?'localized']
     * 
     * (opcional) Si se indica `localized` se buscara la columna en la db según el idioma actual de 
     * la aplicación.
     * 
     * Ej. Se pasa la columna `product`, se ordenara por la columna `product_en` si la
     * aplicación esta en ingles.
     * 
     * @var array
     */
    protected $orderBy = ['name', 'asc'];

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
        $inputs = [
            'name',
            'difficulty_id',
            'introduction',
            'description',
            'instructions',
        ];

        return $inputs;
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
            'difficulty_id' => 'required|exists:' . Difficulty::class . ',id',
            'introduction' => 'required',
            'description' => 'required',
            'instructions' => 'required',
            'goals' => 'required|array',
            'goals.*' => 'exists:' . Goal::class . ',id',
        ];

        if ($method === 'update') {
            $rules['goals'] = str_replace('required', 'nullable', $rules['goals']);
        }

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
     * @param Plan $item 
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
     * @param Plan $item 
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
        $params = $options['params'] ?? null;

        if ($params !== null) {
            $this->handleSearchInput($builder, $params['name']);
            $this->handleDateInput($builder, $params['created_at'], true);
            $this->handleDateInput($builder, $params['updated_at'], true);
        }

        return $builder;
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
            $goals = $data['goals'];

            $data = Arrays::omitKeys($data, [
                'goals'
            ]);

            /** @var Plan */
            $item = parent::create($data);

            $this->updateGoals($item, ManyToManyAction::ATTACH, $goals);

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
            $goals = $data['goals'] ?? [];

            $data = Arrays::omitKeys($data, [
                'goals'
            ]);

            /** @var Plan */
            $item = parent::update($id, $data, $options);

            $this->updateGoals($item, ManyToManyAction::SYNC, $goals);

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
        return $this->defaultUpdateManyToManyRelation($id, $action, $data, array_merge([
            'relationName' => 'goals',
            'relatedKey' => 'goal_id',
        ], $options));
    }
}
