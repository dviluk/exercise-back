<?php

namespace App\Models;

class Workout extends BaseModel
{
    protected $table = 'workouts';

    protected $fillable = [
        'workout_id',
        'difficulty_id',
        'cover',
        'illustration',
        'name',
        'description',
    ];

    /**
     * Si existe, el workout actual es una variación de otro workout.
     */
    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class, 'difficulty_id');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'workout_equipment', 'workout_id', 'equipment_id');
    }

    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'workout_muscle', 'workout_id', 'muscle_id')
            ->withPivot(['primary']);
    }

    public function routines()
    {
        return $this->belongsToMany(Routine::class, 'routine_workout', 'workout_id', 'routine_id');
    }
}
