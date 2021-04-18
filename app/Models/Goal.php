<?php

namespace App\Models;

class Goal extends BaseModel
{
    protected $table = 'goals';

    protected $fillable = [
        'name',
    ];

    public function routines()
    {
        return $this->hasMany(Routine::class, 'difficulty_id');
    }
}
