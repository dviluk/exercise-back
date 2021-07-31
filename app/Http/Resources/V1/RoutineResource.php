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
        if (isset($options['embed'])) {
            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'description' => $resource->description,
            ];
        }

        $format = [
            'id' => $resource->id,
            'name' => $resource->name,
            'description' => $resource->description,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
            'deleted_at' => $resource->deleted_at,
        ];

        if ($resource->relationLoaded('exercises')) {
            $format['exercises'] = [];
            foreach ($resource->exercises as $exercise) {
                $format['exercises'][] = [
                    'id' => $exercise->id,
                    'name' => $exercise->name,
                    'description' => $exercise->description,
                    'order' => (int) $exercise->pivot->order,
                    'repetitions' => (int) $exercise->pivot->repetitions,
                    'quantity' => (int) $exercise->pivot->quantity,
                    // TODO: Eager load pivot relationships
                    'quantity_unit_id' => $exercise->pivot->quantity_unit_id,
                    'rest_time_between_repetitions' => $exercise->pivot->rest_time_between_repetitions,
                    'rest_time_after_exercise' => $exercise->pivot->rest_time_after_exercise,
                ];
            }
        }

        return $format;
    }
}
