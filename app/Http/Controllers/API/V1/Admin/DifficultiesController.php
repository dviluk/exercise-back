<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\DifficultyResource;
use App\Repositories\V1\DifficultiesRepository;

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
}
