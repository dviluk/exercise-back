<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\DifficultyResource;
use App\Models\Difficulty;
use App\Repositories\V1\DifficultiesRepository;
use Illuminate\Http\Request;

class DifficultiesController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\DifficultiesRepository
     */
    protected $repo = DifficultiesRepository::class;

    /**
     * @var \App\Http\Resources\V1\DifficultyResource
     */
    protected $resource = DifficultyResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'name' => 'required|unique:' . Difficulty::class . ',name',
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
