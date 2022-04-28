<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\WorkoutLogResource;
use App\Repositories\V1\WorkoutLogsRepository;

class WorkoutLogsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\WorkoutLogsRepository
     */
    protected $repo = WorkoutLogsRepository::class;

    /**
     * @var \App\Http\Resources\V1\WorkoutLogResource
     */
    protected $resource = WorkoutLogResource::class;

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
