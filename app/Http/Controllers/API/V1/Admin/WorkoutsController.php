<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\WorkoutResource;
use App\Repositories\V1\WorkoutsRepository;

class WorkoutsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\WorkoutsRepository
     */
    protected $repo = WorkoutsRepository::class;

    /**
     * @var \App\Http\Resources\V1\WorkoutResource
     */
    protected $resource = WorkoutResource::class;

    /**
     * Indica las relaciones que se cargaran según el método indicado.
     * 
     * @param string $method 
     * @return array 
     */
    protected function loadRelations(string $method)
    {
        $relations = [];

        return $relations;
    }
}
