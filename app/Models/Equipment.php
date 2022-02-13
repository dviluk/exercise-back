<?php

namespace App\Models;

use App\Enums\Directories;
use Files;

class Equipment extends BaseModel
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'equipment_id');
    }

    public function getImageUrlAttribute()
    {
        return Files::getFileUrl($this->image, Directories::EQUIPMENT_IMAGES);
    }

    public function getImageThumbnailUrlAttribute()
    {
        return Files::getFileUrl($this->image, Directories::EQUIPMENT_IMAGES_THUMBNAILS);
    }
}
