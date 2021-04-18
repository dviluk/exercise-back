<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\GoalResource;
use App\Models\Goal;
use App\Repositories\V1\GoalsRepository;
use Illuminate\Http\Request;

class GoalsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\GoalsRepository
     */
    protected $repo = GoalsRepository::class;

    /**
     * @var \App\Http\Resources\V1\GoalResource
     */
    protected $resource = GoalResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'name' => 'required|unique:' . Goal::class . ',name',
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
