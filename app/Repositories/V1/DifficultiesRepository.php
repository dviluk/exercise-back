<?php

namespace App\Repositories\V1;

use App\Models\Difficulty;
use App\Repositories\Repository;
use App\Repositories\Traits\RepositoryUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Strings;

class DifficultiesRepository extends Repository
{
    use RepositoryUtils;

    /**
     * Classname del modelo principal del repositorio (Model::class).
     *
     * @var string
     */
    protected $model = Difficulty::class;

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
     * Prepara los datos antes de insertar/actualizar un registro.
     * 
     * Se ejecuta antes de request validator.
     * 
     * @param array $data 
     * @param string $method
     * @param array $options 
     * @return array 
     */
    public function prepareData(array $data, string $method, array $options = [])
    {
        if (!array_key_exists('slug', $data)) {
            $data['slug'] = Strings::toSlug($data['name']);
        }

        return $data;
    }

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
            'slug',
            'name',
            'description',
        ];

        if (array_key_exists('customId', $options)) {
            $inputs[] = 'id';
        }

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
            'name' => 'required|unique:' . Difficulty::class . ',name',
            'slug' => 'nullable',
            'description' => 'nullable',
        ];

        if ($method === 'update') {
            $rules['name'] = $rules['name'] . ',' . $id . ',id';
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
     * @param Difficulty $item 
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
     * @param Difficulty $item 
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
     * @return \Illuminate\Support\Collection|Difficulty[]
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
     * @return null|Difficulty
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
     * @return Difficulty
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
     * @return Difficulty
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data, array $options = [])
    {
        return parent::create($data, $options);
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
     * @param array $options
     * @return Difficulty
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
     * @return Difficulty
     * @throws \Exception
     * @throws \Throwable
     */
    public function delete($id, array $options = [])
    {
        return parent::delete($id, $options);
    }
}
