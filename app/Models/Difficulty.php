<?php

namespace App\Models;

class Difficulty extends BaseModel
{
    protected $table = 'difficulties';

    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'difficulty_id');
    }
}
