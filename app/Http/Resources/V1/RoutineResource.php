<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class RoutineResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\Routine $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        $format = [
            'id' => $resource->id,
            'name' => $resource->name,
            'description' => $resource->description,
            'day' => $resource->day,
        ];

        if (isset($options['embed'])) {
            return $format;
        }

        if ($resource->relationLoaded('plan')) {
            $format['plan'] = $resource->plan->name;
        }

        if ($resource->relationLoaded('workouts')) {
            $format['workouts']  = (new WorkoutResource($resource->workouts, [], ['embed' => true]))->toArray();
        }

        $format = array_merge($format, [
            'plan_id' => $resource->plan_id,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ]);

        return $format;
    }
}
