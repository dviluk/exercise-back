<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\RoutineResource;
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
     * Indica las relaciones que se cargaran según el método indicado.
     * 
     * @param string $method 
     * @return array 
     */
    protected function loadRelations(string $method)
    {
        $relations = [];

        if ($method === 'show' || $method === 'edit') {
            $relations = [
                'workouts',
            ];
        }

        return $relations;
    }
}
