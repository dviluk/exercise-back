<?php

namespace App\Http\Controllers;

use App\Utils\API;
use App\Utils\API\Error500;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->repo->paginated(15, [
            'with' => $this->indexRelations(),
        ]);

        return new $this->resource($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->storeValidator($request));

        $data = $this->getStoreData($request);

        $item = $this->repo->create($data);

        $item->load($this->showRelations());

        return new $this->resource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->repo->findOrFail($id, [
            'with' => $this->showRelations(),
        ]);

        return new $this->resource($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->repo->findOrFail($id, [
            'with' => $this->editRelations(),
        ]);

        return new $this->resource($item);
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
        $request->validate($this->updateValidator($request, $id));

        $data = $this->getUpdateData($request, $id);

        $item = $this->repo->update($id, $data);

        $item->load($this->showRelations());

        return new $this->resource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repo->delete($id);

        return API::response200();
    }
}
