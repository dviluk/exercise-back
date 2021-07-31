<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class MuscleResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Muscle $resource 
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

            if ($resource->relationLoaded('pivot') && isset($options['exerciseMuscle'])) {
                $format['primary'] = $resource->pivot->primary == 1;
            }

            return $format;
        }

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
