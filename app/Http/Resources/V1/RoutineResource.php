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
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];

        if ($resource->relationLoaded('workouts')) {
            $format['workouts'] = [];
            foreach ($resource->workouts as $workout) {
                $format['workouts'][] = [
                    'id' => $workout->id,
                    'name' => $workout->name,
                    'description' => $workout->description,
                    'order' => (int) $workout->pivot->order,
                    'repetitions' => (int) $workout->pivot->repetitions,
                    'quantity' => (int) $workout->pivot->quantity,
                    // TODO: Eager load pivot relationships
                    'quantity_unit_id' => $workout->pivot->quantity_unit_id,
                    'rest_time_between_repetitions' => $workout->pivot->rest_time_between_repetitions,
                    'rest_time_after_workout' => $workout->pivot->rest_time_after_workout,
                ];
            }
        }

        return $format;
    }
}
