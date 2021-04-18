<?php

namespace App\Models;

class Routine extends BaseModel
{
    protected $table = 'routines';

    protected $fillable = [
        'name',
        'description',
    ];

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'routine_workout', 'routine_id', 'workout_id')
            ->withPivot([
                'description',
                'order',
                'repetitions',
                'quantity',
                'quantity_unit_id',
                'rest_time_between_repetitions',
                'rest_time_after_workout'
            ]);
    }
}
