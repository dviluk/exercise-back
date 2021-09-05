<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Equipment $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        if (isset($options['embed'])) {
            return [
                'id' => $resource->id,
                'image_url' => $resource->image_url,
                'image_thumbnail_url' => $resource->image_thumbnail_url,
                'name' => $resource->name,
            ];
        }

        return [
            'id' => $resource->id,
            'image_url' => $resource->image_url,
            'image_thumbnail_url' => $resource->image_thumbnail_url,
            'name' => $resource->name,
            'description' => $resource->description,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];
    }
}
