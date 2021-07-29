<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\UnitResource;
use App\Repositories\V1\UnitsRepository;

class UnitsController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\UnitsRepository
     */
    protected $repo = UnitsRepository::class;

    /**
     * @var \App\Http\Resources\V1\UnitResource
     */
    protected $resource = UnitResource::class;
}
