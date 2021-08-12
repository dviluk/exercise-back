<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\ExerciseGroupResource;
use App\Repositories\V1\ExerciseGroupsRepository;

class ExerciseGroupsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\ExerciseGroupsRepository
     */
    protected $repo = ExerciseGroupsRepository::class;

    /**
     * @var \App\Http\Resources\V1\ExerciseGroupResource
     */
    protected $resource = ExerciseGroupResource::class;

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
