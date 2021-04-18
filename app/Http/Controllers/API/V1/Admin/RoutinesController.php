<?php

namespace App\Http\Controllers\API\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\RoutineResource;
use App\Models\Unit;
use App\Models\Workout;
use App\Repositories\V1\RoutinesRepository;

class RoutinesController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\RoutinesRepository
     */
    protected $repo = RoutinesRepository::class;

    /**
     * @var \App\Http\Resources\V1\RoutineResource
     */
    protected $resource = RoutineResource::class;

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
            'description' => 'required',
            'workouts' => 'required|array|min:1',
            'workouts.*.id' => 'exists:' . Workout::class . ',id',
            'workouts.*.description' => 'nullable',
            'workouts.*.order' => 'integer',
            'workouts.*.repetitions' => 'integer',
            'workouts.*.quantity' => 'integer',
            'workouts.*.quantity_unit_id' => 'exists:' . Unit::class . ',id',
            'workouts.*.rest_time_between_repetitions' => 'integer',
            'workouts.*.rest_time_after_workout' => 'integer',
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

        $validations['workouts'] = str_replace('required', 'nullable', $validations['workouts']);

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
            'workouts',
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
