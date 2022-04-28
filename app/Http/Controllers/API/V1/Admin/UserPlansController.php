<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\UserPlanResource;
use App\Repositories\V1\UserPlansRepository;

class UserPlansController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\UserPlansRepository
     */
    protected $repo = UserPlansRepository::class;

    /**
     * @var \App\Http\Resources\V1\UserPlanResource
     */
    protected $resource = UserPlanResource::class;

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
