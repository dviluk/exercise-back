<?php

namespace App\Models;

class Tag extends BaseModel
{
    protected $table = 'tags';

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
