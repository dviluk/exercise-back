<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * Acciones básicas de relaciones many-to-many.
 * 
 * @method static self EQUIPMENT()
 * @method static self EQUIPMENT_IMAGES()
 * @method static self EQUIPMENT_IMAGES_THUMBNAILS()
 * @method static self EXERCISES()
 * @method static self EXERCISES_IMAGES()
 * @method static self EXERCISES_IMAGES_THUMBNAILS()
 * @method static self EXERCISES_ILLUSTRATIONS()
 * @method static self EXERCISES_ILLUSTRATIONS_THUMBNAILS()
 */
final class Directories extends Enum
{
    // IMPORTANT: Todos los directorios inician sin diagonal y terminan con diagonal
    private const EQUIPMENT = 'equipments/';
    private const EQUIPMENT_IMAGES = 'equipments/images/';
    private const EQUIPMENT_IMAGES_THUMBNAILS = 'equipments/images/thumbnails/';
    private const EXERCISES = 'exercises/';
    private const EXERCISES_IMAGES = 'exercises/images/';
    private const EXERCISES_IMAGES_THUMBNAILS = 'exercises/images/thumbnails/';
    private const EXERCISES_ILLUSTRATIONS = 'exercises/illustrations/';
    private const EXERCISES_ILLUSTRATIONS_THUMBNAILS = 'exercises/illustrations/thumbnails/';
}
