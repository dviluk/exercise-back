<?php

namespace App\Repositories;

use App\Utils\API\Error404;
use App\Utils\API\Error500;
use Closure;
use DB;
use Eloquent;
use Error;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use App\Enums\ManyToManyAction;
use App\Utils\ArrayUtils;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     * Clase del modelo.
     * 
     * @var string
     */
    protected $modelClass;

    /**
     * Indica por que columna ordenar los resultados.
     * 
     * ['column', 'asc'|'desc']
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

        $this->modelClass = $this->model;
        // Se crea instancia del modelo
        $this->model = new $this->model;
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

        if (is_array($this->orderBy) && count($this->orderBy) === 2) {
            $column = $this->orderBy[0];

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
        return $data;
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
        $pageName = $options['pageName'] ?? 'page';
        $page = $options['page'] ?? null;

        return $query->paginate($perPage, $columns, $pageName, $page);
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
        // El id puede ser una instancia del modelo principal,
        // eso quiere decir que se puede continuar usando el modelo
        // anteriormente consultado.
        if ($id instanceof $this->modelClass) {
            return $id;
        }

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
    public function create(array $data, array $options = [])
    {
        DB::beginTransaction();
        try {
            $data = $this->prepareData($data, 'create', $options);

            $data = ArrayUtils::preserveKeys($data, $this->availableInputKeys($data));

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
            $data = $this->prepareData($data, 'update', $options);

            $data = ArrayUtils::preserveKeys($data, $this->availableInputKeys($data, true));

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
            $item = $this->findOrFail($id, $options);

            $this->canDelete($item);

            $forceDelete = $options['forceDelete'] ?? false;

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

    /**
     * Acciones básicas para una relación many-to-many.
     * 
     * @param \Illuminate\Database\Eloquent\Relations\BelongsToMany $relation 
     * @param \App\Enums\ManyToManyAction $action 
     * @param array $data 
     * @param bool $isArrayOfIds Indica si $data contiene solo ids 
     * @return array 
     */
    protected function manyToManyActions(BelongsToMany $relation, ManyToManyAction $action, array $data, bool $isArrayOfIds = true)
    {
        $isAttachAction = $action->equals(ManyToManyAction::ATTACH());

        // Cuando es un AttachAction y no se tienen datos, se finaliza el proceso
        if ($isAttachAction && count($data) === 0) {
            return [];
        }

        $isSyncAction = $action->equals(ManyToManyAction::SYNC());

        $isInsertAction = $isAttachAction || $isSyncAction;

        // Cuando los datos no son un array de solo Ids, se le da formato de tal manera
        // cumpla con [$id => [$pivotData]]
        if (!$isArrayOfIds && $isInsertAction) {
            $data = ArrayUtils::formatPivotData($data);
        }

        // Cuando es un AttachAction, se omiten los items que ya existen
        if ($isAttachAction) {
            $currentIds = $relation->pluck('id')->toArray();

            if ($isArrayOfIds) {
                $data = ArrayUtils::omitValues($data, $currentIds);
            } else {
                $data = ArrayUtils::omitKeys($data, $currentIds);
            }
        }

        if ($isArrayOfIds) {
            $changes = $data;
        } else {
            $changes = array_keys($data);
        }

        switch ($action) {
            case ManyToManyAction::ATTACH():
                $relation->attach($data);
                break;
            case ManyToManyAction::DETACH():
                $relation->detach($data);
                break;
            case ManyToManyAction::DETACH_ALL():
                $relation->detach();
                break;
            case ManyToManyAction::SYNC():
                $changes = $relation->sync($data);
                break;
            default:
                throw new Error500([], $action . ': Action not found');
        }

        return $changes;
    }

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
        return [];
    }
}
