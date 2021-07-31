<?php

namespace App\Models;

class Routine extends BaseModel
{
    protected $table = 'routines';

    protected $fillable = [
        'name',
        'description',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercise', 'routine_id', 'exercise_id')
            ->withPivot([
                'description',
                'order',
                'repetitions',
                'quantity',
                'quantity_unit_id',
                'rest_time_between_repetitions',
                'rest_time_after_exercise'
            ]);
    }
}
