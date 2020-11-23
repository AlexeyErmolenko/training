<?php

namespace App\Models;

use App\Models\Helpers\CamelCaseForeignKeys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Saritasa\Database\Eloquent\Models\User as BaseUserModel;
use Saritasa\Enums\Gender;
use Saritasa\Roles\HasRole;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Application User.
 *
 * @property int $id User identifier
 * @property string $firstName User first name
 * @property string $lastName User last name
 * @property string $email User email address
 * @property string $password User encoded password
 * @property string|null $avatarUrl User avatar url
 * @property string|null $remember_token Remember token
 * @property int $role_id Role ID
 * @property Carbon $createdAt Date when user was created
 * @property Carbon $updatedAt Date when user was last time updated
 * @property Carbon|null $deletedAt Date when user was deleted
 *
 * @property-read Collection|Listing[] $listings Listings of the user
 * @property-read Collection|Comment[] $comments Comments of the user
 */
class User extends BaseUserModel implements JWTSubject
{
    use Notifiable;
    use CamelCaseForeignKeys;
    use HasRole;

    
    public const FIRST_NAME = 'firstName';
    public const LAST_NAME = 'lastName';
    public const EMAIL = 'email';
    public const AVATAR = 'avatarUrl';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    public const ROLE_ID = 'role_id';

    public const DEFAULT_AVATAR = 'images/avatar/default.png';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        self::EMAIL,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::AVATAR,
        self::ROLE_ID,
    ];
    /**
     * The attributes that should be visible in arrays.
     *
     * @var string[]
     */
    protected $visible = [
        self::ID,
        self::EMAIL,
        self::FIRST_NAME,
        self::LAST_NAME,
        self::CREATED_AT,
    ];
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        self::ID,
        self::REMEMBER_TOKEN,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
    
    /**
     * The attributes that should not be visible in arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        self::PWD_FIELD,
        self::REMEMBER_TOKEN,
        self::UPDATED_AT,
        self::DELETED_AT,
        self::ROLE_ID,
    ];

    /**
     * Mapping of enum fields.
     *
     * @var mixed[]
     */
    protected $enums = [
        'gender' => Gender::class,
    ];

    /**
     * Mapping of defaults fields.
     *
     * @var mixed[]
     */
    protected $defaults = [
        self::AVATAR => self::DEFAULT_AVATAR,
    ];

    /**
     * {@inheritdoc}
     */
    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
    
    /**
     * Return listings of the user.
     *
     * @return HasMany
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, Listing::CREATED_BY);
    }
    
    /**
     * Return comments for the user.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, Comment::CREATED_BY);
    }
}
