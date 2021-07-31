<?php

namespace App\Models;

class Muscle extends BaseModel
{
    protected $table = 'muscles';

    protected $fillable = [
        'name',
        'description',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_muscle', 'exercise_id', 'muscle_id')
            ->withPivot(['primary']);
    }
}
