<?php

namespace App\Enums;

use Saritasa\Enum;

/**
 * Available roles in the system.
 */
class Roles extends Enum
{
    public const USER = 1;
    public const ADMIN = 2;
}
