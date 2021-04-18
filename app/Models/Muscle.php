<?php

namespace App\Models;

class Muscle extends BaseModel
{
    protected $table = 'muscles';

    protected $fillable = [
        'name',
        'description',
    ];

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_muscle', 'workout_id', 'muscle_id')
            ->withPivot(['primary']);
    }
}
