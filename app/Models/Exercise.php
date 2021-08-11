<?php

namespace App\Models;

class Exercise extends BaseModel
{
    protected $table = 'exercises';

    protected $fillable = [
        'difficulty_id',
        'image',
        'illustration',
        'name',
        'description',
    ];

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class, 'difficulty_id');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'exercise_equipment', 'exercise_id', 'equipment_id');
    }

    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'exercise_muscle', 'exercise_id', 'muscle_id')
            ->withPivot(['primary']);
    }
}
