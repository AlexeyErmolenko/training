<?php

namespace App\Models;

use App\Models\Helpers\CamelCaseForeignKeys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model for entity image.
 *
 * @property int $id Image identifier
 * @property int $listingId Listing identifier
 * @property int $createdBy User created
 * @property string $message Message of the comment
 * @property Carbon $createdAt Date of creating the entity
 * @property Carbon $updatedAt Date of updating the entity
 * @property Carbon $deletedAt Date of deleting the entity
 */
class Comment extends Model
{
    use CamelCaseForeignKeys;
    use SoftDeletes;

    public const ID = 'id';
    public const LISTING_ID = 'listingId';
    public const CREATED_BY = 'createdBy';
    public const MESSAGE = 'message';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Comments';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];
    
    /**
     * The attributes that should be visible in arrays.
     *
     * @var string[]
     */
    protected $visible = [
        self::ID,
        self::LISTING_ID,
        self::MESSAGE,
        self::CREATED_BY,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        self::LISTING_ID,
        self::MESSAGE,
    ];
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        self::ID,
        self::CREATED_BY,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];
}
