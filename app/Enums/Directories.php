<?php

namespace App\Enums;

/**
 * Acciones básicas de relaciones many-to-many.
 */
enum Directories: string
{
    // IMPORTANT: Todos los directorios inician sin diagonal y terminan con diagonal
    case EQUIPMENT = 'equipments/';
    case EQUIPMENT_IMAGES = 'equipments/images/';
    case EQUIPMENT_IMAGES_THUMBNAILS = 'equipments/images/thumbnails/';
    case EXERCISES = 'exercises/';
    case EXERCISES_IMAGES = 'exercises/images/';
    case EXERCISES_IMAGES_THUMBNAILS = 'exercises/images/thumbnails/';
    case EXERCISES_ILLUSTRATIONS = 'exercises/illustrations/';
    case EXERCISES_ILLUSTRATIONS_THUMBNAILS = 'exercises/illustrations/thumbnails/';
}
