<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\MuscleResource;
use App\Models\Muscle;
use App\Repositories\V1\MusclesRepository;
use Illuminate\Http\Request;

class MusclesController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\MusclesRepository
     */
    protected $repo = MusclesRepository::class;

    /**
     * @var \App\Http\Resources\V1\MuscleResource
     */
    protected $resource = MuscleResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'name' => 'required|unique:' . Muscle::class . ',name',
            'description' => 'required',
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
        $validations = $this->storeValidator($request);

        $validations['name'] = $validations['name'] . ',' . $id . ',id';

        return $validations;
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
}
