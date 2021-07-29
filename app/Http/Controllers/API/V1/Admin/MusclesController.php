<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\MuscleResource;
use App\Repositories\V1\MusclesRepository;

class MusclesController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\MusclesRepository
     */
    protected $repo = MusclesRepository::class;

    /**
     * @var \App\Http\Resources\V1\MuscleResource
     */
    protected $resource = MuscleResource::class;
}
