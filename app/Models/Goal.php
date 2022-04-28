<?php

namespace App\Models;

class Goal extends BaseModel
{
    protected $table = 'goals';

    protected $fillable = [
        'name',
        'description',
    ];
}
