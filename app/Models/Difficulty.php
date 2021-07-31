<?php

namespace App\Models;

class Difficulty extends BaseModel
{
    protected $table = 'difficulties';

    protected $fillable = [
        'name',
        'description',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'difficulty_id');
    }

    public function routines()
    {
        return $this->hasMany(Routine::class, 'difficulty_id');
    }
}
