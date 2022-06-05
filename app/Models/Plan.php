<?php

namespace App\Models;

class Plan extends BaseModel
{
    protected $table = 'plans';

    protected $fillable = [
        'name',
        'difficulty_id',
        'introduction',
        'description',
        'weeks',
    ];

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'plan_goal');
    }

    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
}
