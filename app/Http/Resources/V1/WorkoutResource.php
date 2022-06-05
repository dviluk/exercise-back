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
            'sets' => $resource->sets,
            'rest' => $resource->rest,
            'order' => $resource->order,
            'min_repetitions' => $resource->min_repetitions,
            'max_repetitions' => $resource->max_repetitions,
        ];

        if ($resource->relationLoaded('exercise')) {
            $format['exercise'] =  $resource->exercise->name;
        }

        if ($resource->relationLoaded('difficulty')) {
            $format['difficulty'] =  $resource->difficulty->name;
        }

        if ($resource->relationLoaded('plan')) {
            $format['plan'] =  $resource->plan->name;
        }

        if ($resource->relationLoaded('routine')) {
            $format['routine'] =  $resource->routine->name;
        }

        if (isset($options['embed'])) {
            return $format;
        }

        $format = array_merge($format, [
            'exercise_id' => $resource->exercise_id,
            'difficulty_id' => $resource->difficulty_id,
            'plan_id' => $resource->plan_id,
            'routine_id' => $resource->routine_id,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ]);

        return $format;
    }
}
