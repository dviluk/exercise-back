<?php

namespace App\Models;

class Routine extends BaseModel
{
    protected $table = 'routines';

    protected $fillable = [
        'id',
        'name',
        'description',
        'plan_id',
        'day',
    ];

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_routine');
    }
}
