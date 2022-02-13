<?php

namespace App\Models;

use App\Enums\Directories;
use Files;

class Exercise extends BaseModel
{
    protected $table = 'exercises';

    protected $fillable = [
        'difficulty_id',
        'image',
        'illustration',
        'name',
        'description',
    ];

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

    public function getImageUrlAttribute()
    {
        return Files::getFileUrl($this->image, Directories::EXERCISES_IMAGES);
    }

    public function getImageThumbnailUrlAttribute()
    {
        return Files::getFileUrl($this->image, Directories::EXERCISES_IMAGES_THUMBNAILS);
    }

    public function getIllustrationUrlAttribute()
    {
        return Files::getFileUrl($this->illustration, Directories::EXERCISES_ILLUSTRATIONS);
    }

    public function getIllustrationThumbnailUrlAttribute()
    {
        return Files::getFileUrl($this->image, Directories::EXERCISES_ILLUSTRATIONS_THUMBNAILS);
    }
}
