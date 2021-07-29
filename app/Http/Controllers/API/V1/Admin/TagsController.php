<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\TagResource;
use App\Repositories\V1\TagsRepository;

class TagsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\TagsRepository
     */
    protected $repo = TagsRepository::class;

    /**
     * @var \App\Http\Resources\V1\TagResource
     */
    protected $resource = TagResource::class;
}
