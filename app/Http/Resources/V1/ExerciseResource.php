<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Exercise $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        $format = [
            'id' => $resource->id,
            'difficulty_id' => $resource->difficulty_id,
            'image_url' => $resource->image_url,
            'image_thumbnail_url' => $resource->image_thumbnail_url,
            'illustration_url' => $resource->illustration_url,
            'illustration_thumbnail_url' => $resource->illustration_thumbnail_url,
            'name' => $resource->name,
            'description' => $resource->description,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];

        if ($resource->relationLoaded('difficulty')) {
            $format['difficulty'] = $resource->difficulty->name;
        }

        if ($resource->relationLoaded('equipment')) {
            $format['equipment'] = (new EquipmentResource($resource->equipment, [], ['embed' => true]))->toArray();
        }

        if ($resource->relationLoaded('muscles')) {
            $format['muscles'] = (new MuscleResource($resource->muscles, [], ['embed' => true, 'exerciseMuscle' => true]))->toArray();
        }

        return $format;
    }
}
