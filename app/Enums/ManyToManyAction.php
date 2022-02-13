<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * Acciones básicas de relaciones many-to-many.
 */
enum ManyToManyAction: string
{
    case ATTACH = 'ATTACH';
    case DETACH = 'DETACH';
    case DETACH_ALL = 'DETACH_ALL';
    case SYNC = 'SYNC';
}
