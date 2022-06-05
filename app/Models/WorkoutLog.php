<?php

namespace App\Models;

class WorkoutLog extends BaseModel
{
    protected $table = 'workout_logs';

    protected $fillable = [
        'id',
        'user_id',
        'workout_id',
        'plan_id',
        'sets',
        'repetitions',
        'rest',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
