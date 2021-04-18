<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Tag $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        if (isset($options['embed'])) {
            $format = [
                'id' => $resource->id,
                'name' => $resource->name,
            ];
        } else {
            $format = [
                'id' => $resource->id,
                'name' => $resource->name,
                'description' => $resource->description,
                'created_at' => $resource->created_at,
                'updated_at' => $resource->updated_at,
                'deleted_at' => $resource->deleted_at,
            ];
        }

        return $format;
    }
}
