<?php

namespace App\Models;

class Equipment extends BaseModel
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'description',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'equipment_id');
    }
}
