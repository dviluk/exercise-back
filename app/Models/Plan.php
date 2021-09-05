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
        'instructions',
    ];

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class, 'difficulty_id');
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'plan_goal', 'plan_id', 'goal_id');
    }

    public function exerciseGroups()
    {
        return $this->belongsToMany(ExerciseGroup::class, 'plan_group', 'plan_id', 'group_id');
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'plan_exercise', 'plan_id', 'exercise_id');
    }
}
