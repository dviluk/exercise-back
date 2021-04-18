<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\UnitResource;
use App\Repositories\V1\UnitsRepository;
use Illuminate\Http\Request;

class UnitsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\UnitsRepository
     */
    protected $repo = UnitsRepository::class;

    /**
     * @var \App\Http\Resources\V1\UnitResource
     */
    protected $resource = UnitResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'name',
            'description',
        ];
    }

    /**
     * Get data from store request.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function getStoreData(Request $request): array
    {
        return $request->all();
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
        return $this->storeValidator($request);
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
        return $this->getStoreData($request);
    }

    /**
     * Relaciones a cargar al consultar el listado.
     * 
     * @return array 
     */
    protected function indexRelations()
    {
        return [
            //
        ];
    }

    /**
     * Relaciones a cargar al consultar 1 elemento.
     * 
     * @return array 
     */
    protected function showRelations()
    {
        return [
            //
        ];
    }

    /**
     * Relaciones a cargar al consultar 1 elemento a editar.
     * 
     * @return array 
     */
    protected function editRelations()
    {
        return $this->showRelations();
    }
}
