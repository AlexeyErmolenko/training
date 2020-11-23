<?php

namespace App\Dto;

use App\Enums\Roles;
use Saritasa\Dto;

/**
 * User create/update data.
 */
class UserData extends Dto
{
    public const FIRST_NAME = 'firstName';
    public const LAST_NAME = 'lastName';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const AVATAR = 'avatarUrl';
    
    /**
     * User first name.
     *
     * @var string
     */
    public $firstName;
    
    /**
     * User last name.
     *
     * @var string
     */
    public $lastName;
    
    /**
     * User email.
     *
     * @var string
     */
    public $email;
    
    /**
     * User password.
     *
     * @var string
     */
    public $password;
    
    /**
     * User avatar.
     *
     * @var string
     */
    public $avatarUrl;
    
    /**
     * User role;
     *
     * @var int
     */
    public $role_id = Roles::USER;
}
