<?php

namespace App\Models;

use App\Models\Helpers\CamelCaseForeignKeys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model for entity listing.
 *
 * @property int $id Listing identifier
 * @property int $carModelId Car model identifier
 * @property int $carTrimId Car trim identifier
 * @property int $createdBy User created
 * @property int $year Year of the car
 * @property float $price Price of the car
 * @property Carbon $createdAt Date of creating the entity
 * @property Carbon $updatedAt Date of updating the entity
 * @property Carbon $deletedAt Date of deleting the entity
 */
class Listing extends Model
{
    use CamelCaseForeignKeys;
    use SoftDeletes;
    
    public const ID = 'id';
    public const CAR_MODEL_ID = 'carModelId';
    public const CAR_TRIM_ID = 'carTrimId';
    public const CREATED_BY = 'createdBy';
    public const YEAR = 'year';
    public const PRICE = 'price';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Listings';
    
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
        self::CAR_MODEL_ID,
        self::CAR_TRIM_ID,
        self::CREATED_BY,
        self::YEAR,
        self::PRICE,
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
        self::CAR_MODEL_ID,
        self::CAR_TRIM_ID,
        self::YEAR,
        self::PRICE,
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
