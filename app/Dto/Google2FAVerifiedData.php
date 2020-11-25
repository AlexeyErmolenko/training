<?php

namespace App\Dto;

use Saritasa\Dto;

class Google2FAVerifiedData extends Dto
{
    public const CODE = 'code';
    
    /**
     * @var string
     */
    public $code;
}
