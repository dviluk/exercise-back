<?php

namespace App\Models;

class Exercise extends BaseModel
{
    protected $table = 'exercises';

    protected $fillable = [
        'exercise_id',
        'difficulty_id',
        'cover',
        'illustration',
        'name',
        'description',
    ];

    /**
     * Si existe, el exercise actual es una variación de otro exercise.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

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
