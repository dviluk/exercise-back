<?php

namespace App\Models;

class Equipment extends BaseModel
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'description',
    ];

    public function workouts()
    {
        return $this->hasMany(Workout::class, 'difficulty_id');
    }
}
