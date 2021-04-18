<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\PlanResource;
use App\Models\Difficulty;
use App\Models\Goal;
use App\Models\Routine;
use App\Repositories\V1\PlansRepository;
use Illuminate\Http\Request;

class PlansController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\PlansRepository
     */
    protected $repo = PlansRepository::class;

    /**
     * @var \App\Http\Resources\V1\PlanResource
     */
    protected $resource = PlanResource::class;

    /**
     * Validate store request input.
     * 
     * @param \Illuminate\Http\Request $request 
     * @return array 
     */
    protected function storeValidator(Request $request): array
    {
        return [
            'name' => 'required',
            'difficulty_id' => 'required|exists:' . Difficulty::class . ',id',
            'introduction' => 'required',
            'description' => 'required',
            'instructions' => 'required',
            'goals' => 'required|array',
            'goals.*' => 'exists:' . Goal::class . ',id',
            'routines' => 'required|array',
            'routines.*' => 'exists:' . Routine::class . ',id',
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

        $validations['goals'] = str_replace('required', 'nullable', $validations['goals']);
        $validations['routines'] = str_replace('required', 'nullable', $validations['routines']);

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

    /**
     * Relaciones a cargar al consultar el listado.
     * 
     * @return array 
     */
    protected function indexRelations()
    {
        return [
            'difficulty'
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
            'difficulty',
            'goals',
            'routines',
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
