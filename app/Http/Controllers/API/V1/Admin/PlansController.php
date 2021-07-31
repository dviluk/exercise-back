<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\PlanResource;
use App\Repositories\V1\PlansRepository;

class PlansController extends CRUDController
{
    /**
     * Instancia del repositorio.
     * 
     * @var \App\Repositories\V1\PlansRepository
     */
    protected $repo = PlansRepository::class;

    /**
     * @var \App\Http\Resources\V1\PlanResource
     */
    protected $resource = PlanResource::class;

    /**
     * Indica las relaciones que se cargaran según el método indicado.
     * 
     * @param string $method 
     * @return array 
     */
    protected function loadRelations(string $method)
    {
        $relations = [];

        if ($method === 'index') {
            $relations = [
                'difficulty',
            ];
        }

        if ($method === 'show' || $method === 'edit') {
            $relations = [
                'difficulty',
                'goals',
            ];
        }

        return $relations;
    }
}
