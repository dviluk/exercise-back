<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\GoalResource;
use App\Repositories\V1\GoalsRepository;

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
}
