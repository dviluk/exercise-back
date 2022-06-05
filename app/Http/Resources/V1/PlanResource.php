<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Plan $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        $formatted = [
            'id' => $resource->id,
            'name' => $resource->name,
            'difficult_id' => $resource->difficulty_id,
            'introduction' => $resource->introduction,
            'description' => $resource->description,
            'instructions' => $resource->instructions,
            'weeks' => (int) $resource->weeks,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];

        if (isset($options['editing'])) {
            $formatted['goals'] = $resource->goals->pluck('id')->toArray();
            $formatted['routines'] = $resource->routines->pluck('id')->toArray();
            $formatted['workouts'] = $resource->workouts->pluck('id')->toArray();

            return $formatted;
        }

        if ($resource->relationLoaded('difficulty')) {
            $formatted['difficulty'] = $resource->difficulty->name;
        }

        if ($resource->relationLoaded('goals')) {
            $formatted['goals'] = (new GoalResource($resource->goals, [], ['embed' => true]))->toArray();
        }

        if ($resource->relationLoaded('routines')) {
            $formatted['routines'] = (new RoutineResource($resource->routines, [], ['embed' => true]))->toArray();
        }

        if ($resource->relationLoaded('workouts')) {
            $formatted['workouts'] = (new WorkoutResource($resource->workouts, [], ['embed' => true]))->toArray();
        }

        return $formatted;
    }
}
