<?php

namespace App\Models;

class Difficulty extends BaseModel
{
    protected $table = 'difficulties';

    protected $fillable = [
        'name',
        'description',
    ];

    public function workouts()
    {
        return $this->hasMany(Workout::class, 'difficulty_id');
    }

    public function routines()
    {
        return $this->hasMany(Routine::class, 'difficulty_id');
    }
}
