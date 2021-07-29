<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\EquipmentResource;
use App\Repositories\V1\EquipmentRepository;

class EquipmentController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\EquipmentRepository
     */
    protected $repo = EquipmentRepository::class;

    /**
     * @var \App\Http\Resources\V1\EquipmentResource
     */
    protected $resource = EquipmentResource::class;
}
