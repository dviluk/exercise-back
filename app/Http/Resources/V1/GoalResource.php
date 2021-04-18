<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class GoalResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Goal $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'description' => $resource->description,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];
    }
}
