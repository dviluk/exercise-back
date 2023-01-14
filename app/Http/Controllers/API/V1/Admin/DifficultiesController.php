<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\CRUDController;
use App\Http\Resources\V1\DifficultyResource;
use App\Repositories\V1\DifficultiesRepository;

/**
 * @OA\Get(
 *  path="/api/v1/difficulties",
 *  description="Difficulties",
 *  @OA\Response(
 *      response=200, 
 *      description="List of categories",
 *      @OA\JsonContent(
 *        type="string",
 *        required={"name"},
 *        @OA\Property(property="name", type="string")
 *      )
 *  )
 * )
 * @OA\GET(
 *   path="/api/v1/difficulties/{id}",
 *   description="Item",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Item",
 *     @OA\JsonContent(
 *       type="string",
 *       required={"name"},
 *       @OA\Property(property="name", type="string")
 *     )
 *   )
 * )
 */
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
