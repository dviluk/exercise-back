<?php

namespace App\Models;

class ExerciseGroup extends BaseModel
{
    protected $table = 'exercise_groups';

    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Plan::class, 'exercise_group', 'group_id', 'exercise_id');
    }
}
