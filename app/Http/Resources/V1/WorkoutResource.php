<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class WorkoutResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Workout $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        $format = [
            'id' => $resource->id,
            'workout_id' => $resource->workout_id,
            'difficulty_id' => $resource->difficulty_id,
            'cover' => $resource->cover,
            'illustration' => $resource->illustration,
            'name' => $resource->name,
            'description' => $resource->description,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];

        if ($resource->relationLoaded('workout')) {
            $format['workout'] = $resource->workout->name ?? null;
        }

        if ($resource->relationLoaded('difficulty')) {
            $format['difficulty'] = $resource->difficulty->name;
        }

        if ($resource->relationLoaded('equipment')) {
            $format['equipment'] = (new EquipmentResource($resource->equipment, [], ['embed' => true]))->toArray();
        }

        if ($resource->relationLoaded('muscles')) {
            $format['muscles'] = (new MuscleResource($resource->muscles, [], ['embed' => true, 'workoutMuscle' => true]))->toArray();
        }

        return $format;
    }
}
