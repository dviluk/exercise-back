<?php

namespace App\Http\Controllers;

use App\Utils\API;
use App\Utils\API\Error500;
use DB;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\Repository
     */
    protected $repo;

    /**
     * @var \App\Utils\Json\JsonResource
     */
    protected $resource;

    /**
     * Indica si se utilizaran los métodos localizados del repositorio.
     * 
     * @var boolean
     */
    protected $localized = false;

    public function __construct()
    {
        if (!is_string($this->repo)) {
            throw new Error500([], '$this->repo not valid');
        }

        if (!is_string($this->resource)) {
            throw new Error500([], '$this->resource not valid');
        }

        $this->repo = new $this->repo;
    }

    /**
     * Get data from update request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @param string $id 
     * @return array 
     */
    protected function updateValidator(Request $request, string $id): array
    {
        return [];
    }

    /**
     * Get data from update request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @param string $id 
     * @return array 
     */
    protected function getUpdateData(Request $request, string $id): array
    {
        return [];
    }

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [];
    }

    /**
     * Get data from store request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function getStoreData(Request $request): array
    {
        return [];
    }

    /**
     * Relaciones a cargar al consultar el listado.
     * 
     * @return array 
     */
    protected function indexRelations()
    {
        return [];
    }

    /**
     * Relaciones a cargar al consultar 1 elemento.
     * 
     * @return array 
     */
    protected function showRelations()
    {
        return [];
    }

    /**
     * Relaciones a cargar al consultar 1 elemento a editar.
     * 
     * @return array 
     */
    protected function editRelations()
    {
        return [];
    }

    /**
     * Retorna las opciones que se aplicaran en el método indicado.
     * 
     * @param mixed $method 
     * @return array 
     */
    protected function options($method)
    {
        return [];
    }

    /**
     * Permite ejecutar una acción antes de ejecutar el `$repo->create()` o `$repo->update()`.
     * 
     * @param string $method 
     * @param array $data 
     * @param int|null $id Se para cuando $method = 'update'
     * @param \Eloquent|null $item Se para cuando $method = 'update'
     * @return void 
     */
    protected function preAction(string $method, array $data, $id = null, $item = null): array
    {
        return $data;
    }

    /**
     * Permite ejecutar una acción después de ejecutar el `$repo->create()` o `$repo->update()`.
     * 
     * @param string $method 
     * @param array $data 
     * @return void 
     */
    protected function postAction(string $method, $item)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $method = $this->localized  ? 'paginatedLocalized' : 'paginated';

        $queryOptions = $this->_queryOptions('index', [
            'with' => $this->indexRelations(),
        ]);

        $resourceOptions = $queryOptions['resourceOptions'] ?? [];

        $items = $this->repo->{$method}(15, $queryOptions);

        return new $this->resource($items, [], $resourceOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $method = $this->localized  ? 'createLocalized' : 'create';

        $request->validate($this->storeValidator($request));

        $data = $this->getStoreData($request);

        $queryOptions = $this->_queryOptions('store');

        $resourceOptions = $queryOptions['resourceOptions'] ?? [];

        DB::beginTransaction();
        try {
            $data = $this->preAction('store', $data);

            $item = $this->repo->{$method}($data);

            $this->postAction('store', $item);

            $item->load($this->showRelations());

            DB::commit();

            return new $this->resource($item, [],  $resourceOptions);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $method = $this->localized  ? 'findOrFailLocalized' : 'findOrFail';

        $queryOptions = $this->_queryOptions('show', [
            'with' => $this->showRelations(),
        ]);

        $resourceOptions = $queryOptions['resourceOptions'] ?? [];

        $item = $this->repo->{$method}($id, $queryOptions);

        return new $this->resource($item, [], $resourceOptions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $queryOptions = $this->_queryOptions('edit', [
            'with' => $this->editRelations(),
        ]);

        $resourceOptions = $queryOptions['resourceOptions'] ?? [];

        $item = $this->repo->findOrFail($id, $queryOptions);

        return new $this->resource($item, [], $resourceOptions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $method = $this->localized  ? 'updateLocalized' : 'update';

        $request->validate($this->updateValidator($request, $id));

        $data = $this->getUpdateData($request, $id);

        $queryOptions = $this->_queryOptions('update');

        $resourceOptions = $queryOptions['resourceOptions'] ?? [];

        DB::beginTransaction();
        try {
            $item = $this->repo->findOrFail($id);

            $data = $this->preAction('update', $data, $id, $item);

            $item = $this->repo->{$method}($item, $data);

            $this->postAction('update', $item);

            $item->load($this->showRelations());

            DB::commit();

            return new $this->resource($item, [], $resourceOptions);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $queryOptions = $this->_queryOptions('destroy');

        $this->repo->delete($id, $queryOptions);

        return API::response200();
    }

    /**
     * Retorna las opciones que se pasaran a la consulta.
     * 
     * @param mixed $method 
     * @param array $attach 
     * @return array 
     */
    private function _queryOptions($method, $attach = [])
    {
        return array_merge_recursive($this->options($method), $attach);
    }
}
