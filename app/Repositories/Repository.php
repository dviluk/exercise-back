<?php

namespace App\Repositories;

use App\Utils\API\Error404;
use App\Utils\API\Error500;
use App\Utils\Lang;
use Closure;
use DB;
use Eloquent;
use Error;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Throwable;

/**
 * Repositorio base para manipular el CRUD de un modelo Laravel
 */
class Repository
{
    /**
     * Modelo principal de repositorio.
     *
     * En la clase hijo se debe declarar la clase del modelo
     * de la siguiente manera:
     *
     * ```php
     * protected $model = Model::class;
     * ```
     *
     * Al instanciar el repositorio, el modelo `$this->model`
     * se instancia.
     *
     * @var \Eloquent|string
     */
    protected $model;
    /**
     * @var \Eloquent
     */
    protected $modelInstance;

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
    protected $orderBy = [];

    protected $defaultColumns = ['*'];

    public function __construct()
    {
        $this->validateModel();

        // Se crea instancia del modelo
        $this->model = new $this->model;
        $this->modelInstance = $this->model;
    }

    /**
     * Prepara el query base.
     *
     * @param array $options
     *
     *  - array `$options['where']` Contiene las condiciones básicas que se aplicaran al query.
     *
     * Ej:
     * ```php
     *  $where = [
     *       [column, operator, value],
     *       [column, operator, value],
     *  ];
     * ```
     *
     *  - array `$options['with']` Contiene las relaciones que se pre-cargaran junto al modelo.
     *
     * Ej:
     * ```php
     * $with = [
     *     relation => closure
     * ];
     *
     * // O
     *
     * $with = relation;
     * ```
     *
     *  - \Closure `$options['builder']` El closure recibe el $query como parámetro, para crear queries mas avanzados.
     *
     * Ej:
     * ```php
     * $builder = closure(Builder $queryBuilder);
     * ```
     *
     * - string|int `$options['find']` Elemento a buscar.
     * - string `$options['columnId']` Nombre de la columna donde buscara el valor de `$options['find']`.
     *
     * @return Builder
     * @throws Error
     */
    private function initQuery($options = [])
    {
        $query = $this->model::query();

        $columnId = $this->model->getKeyName();

        if (is_array($this->orderBy) && count($this->orderBy) >= 2) {
            $localize = isset($this->orderBy[2]) && $this->orderBy[2] === 'localized';

            $column = $this->orderBy[0];

            if ($localize) {
                $column = Lang::dbColumn($column);
            }

            $query->orderBy($column, $this->orderBy[1]);
        }

        if ($options instanceof Closure) {
            $options($query);
        } else if (is_array($options)) {
            if (isset($options['where'])) {
                $where = $options['where'];
                if (is_array($where)) {
                    $query->where($where);
                } else {
                    throw new Error("`\$options['where']` no es valido");
                }
            }

            if (isset($options['whereIn'])) {
                foreach ($options['whereIn'] as $whereIn) {
                    if (count($whereIn) === 2) {
                        $query->whereIn($whereIn[0], $whereIn[1]);
                    } else {
                        throw new Error500([], "`\$options['whereIn']` no es valido");
                    }
                }
            }

            if (isset($options['with'])) {
                $with = $options['with'];
                if (is_array($with) || is_string($with)) {
                    $query->with($with);
                } else {
                    throw new Error("`\$options['with']` no es valido");
                }
            }

            if (isset($options['has'])) {
                $has = $options['has'];
                if (is_array($has)) {
                    foreach ($has as $rel => $callback) {
                        $query->whereHas($rel, $callback);
                    }
                } else if (is_string($has)) {
                    $query->whereHas($has);
                } else {
                    throw new Error("`\$options['has']` no es valido");
                }
            }

            $builder = $options['builder'] ?? null;
            if ($builder instanceof \Closure) {
                $builder($query);
            }

            // en caso de que `id` no sea la llave primaria o
            // se desea utilizar otra columna para la búsqueda
            if (isset($options['columnId'])) {
                $columnId = $options['columnId'];
            }

            if (isset($options['find'])) {
                $query->where($columnId, $options['find']);
            }
        }

        return $query;
    }

    /**
     * Permite encargarse de las opciones adicionales.
     *
     * @param Builder $builder
     * @param array $options
     * @return Builder
     */
    public function handleOptions(Builder $builder, array $options = []): Builder
    {
        return $builder;
    }

    /**
     * Modifica el query después de `$this->handleOptions($q, $options)`.
     * 
     * @param Builder $builder 
     * @return Builder 
     */
    public function modifyQuery(Builder $builder): Builder
    {
        return $builder;
    }

    /**
     * Retornar el query configurado.
     *
     * @param array $options Las mismas opciones que en `Repository::initQuery($options)`
     * @return Builder
     * @throws Error
     */
    public function query(array $options = []): Builder
    {
        $query = $this->initQuery($options);

        $this->handleOptions($query, $options);
        $this->modifyQuery($query);

        return $query;
    }

    /**
     * Consulta todos los registros.
     *
     * @param array $options Las mismas opciones que en `Repository::initQuery($options)`
     * @return Collection
     * @throws Error
     */
    public function all(array $options = [])
    {
        $query = $this->query($options);

        $columns = $options['columns'] ?? $this->defaultColumns;

        return $query->get($columns);
    }

    /**
     * Retorna los registros paginados.
     * 
     * @param int $perPage 
     * @param array $options 
     * @return LengthAwarePaginator 
     * @throws Error 
     * @throws InvalidArgumentException 
     */
    public function paginated($perPage = 15, $options = [])
    {
        $query = $this->query($options);

        if (config('app.debug') === false && !in_array($perPage, $this->paginationOptions())) {
            $perPage = 15;
        }

        $columns = $options['columns'] ?? $this->defaultColumns;

        return $query->paginate($perPage, $columns);
    }

    /**
     * Retorna los números de pagina que se pueden aplicar.
     *
     * @return array
     */
    public function paginationOptions(): array
    {
        return [15, 25, 30, 50, 100];
    }

    /**
     * Busca un registro por ID.
     *
     * @param mixed $id
     * @param array $options Las mismas opciones que en `Repository::initQuery($options)`
     * @return null|Eloquent
     * @throws Error
     */
    public function find($id, array $options = [])
    {
        $query = $this->query(array_merge($options, ['find' => $id]));

        $columns = $options['columns'] ?? $this->defaultColumns;

        return $query->first($columns);
    }

    /**
     * 
     * @param mixed $id 
     * @param array $options 
     * @return Eloquent 
     * @throws Error 
     * @throws Error404 
     */
    public function findOrFail($id, array $options = [])
    {
        $item = $this->find($id, $options);

        if (!$item) {
            throw new Error404();
        }

        return $item;
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
     * Crea un nuevo registro.
     *
     * @param array $data Contiene los campos a insertar en la tabla del modelo.
     * @return Eloquent
     * @throws Exception
     * @throws Throwable
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $this->canCreate($data);

            $item = $this->model::create($data);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Valida si se puede editar el registro.
     *
     * @param Eloquent $item
     * @return void
     */
    public function canUpdate($item, ?array $data = [])
    {
        //
    }

    /**
     * Actualiza un registro.
     *
     * @param mixed $id
     * @param array $data Contiene los campos a actualizar.
     * @param array $options
     * @return Eloquent
     * @throws Exception
     * @throws Throwable
     */
    public function update($id, array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $item = $this->findOrFail($id, $options);

            $this->canUpdate($item, $data);

            $item->update($data);

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Valida si se puede eliminar el registro.
     *
     * @param Eloquent $item
     * @return void
     */
    public function canDelete($item)
    {
        //
    }

    /**
     * Elimina un registro.
     *
     * @param mixed $id
     * @param array $options
     * @return Eloquent
     * @throws Exception
     * @throws Throwable
     */
    public function delete($id, array $options = [])
    {
        DB::beginTransaction();
        try {
            $item = $this->find($id, $options);

            // validar que el registro exista
            if (!$item) {
                throw new Error404();
            }

            $this->canDelete($item);

            $forceDelete = $options['force_delete'] ?? false;

            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($item)) && $forceDelete === true) {
                $item->forceDelete();
            } else {
                // eliminar el registro
                $item->delete();
            }

            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();

            if (strpos($e->getMessage(), 'Integrity constraint violation: 1451') !== false) {
                throw new Error500([], 'This item cannot be deleted, has data associated.');
            }

            throw $e;
        }
    }

    /**
     * Se encarga de validar que el `$this->model`
     * sea un string valido.
     *
     * @return void
     * @throws Error
     */
    private function validateModel()
    {
        if (!is_string($this->model)) {
            throw new \Error('`$this->model` not valid:' . $this->model);
        }
    }
}
