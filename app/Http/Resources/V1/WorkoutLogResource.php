<?php

namespace App\Http\Resources\V1;

use App\Utils\Json\JsonResource;

class WorkoutLogResource extends JsonResource
{
    /**
     * Da formato al recurso.
     * 
     * @param \App\Models\WorkoutLog $resource 
     * @param array $options 
     * @return array 
     */
    public function formatter($resource, array $options): array
    {
        return [
            'id' => $resource->id,
            'user_id' => $resource->user_id,
            'workout_id' => $resource->workout_id,
            'routine_id' => $resource->routine_id,
            'plan_id' => $resource->plan_id,
            'sets' => (int)$resource->sets,
            'repetitions' => (int)$resource->repetitions,
            'rest' => (int)$resource->rest,
            'time' => (int)$resource->time,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];
    }
}
