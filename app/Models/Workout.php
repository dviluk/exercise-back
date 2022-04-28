<?php

namespace App\Models;

class Workout extends BaseModel
{
    protected $table = 'workouts';

    protected $fillable = [
        'id',
        'exercise_id',
        'difficulty_id',
        'plan_id',
        'routine_id',
        'sets',
        'rest',
        'order',
        'min_repetitions',
        'max_repetitions',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class);
    }

    public function logs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
