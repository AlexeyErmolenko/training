<?php

namespace App\Models;

use App\Models\Helpers\CamelCaseForeignKeys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Model for entity car models.
 *
 * @property int $id Car model identifier
 * @property int $makeId Car maker identifier
 * @property string $name  Name of the car model
 * @property int $yearStart Year of car model production start
 * @property int $yearEnd Year of car model production end
 * @property Carbon $createdAt Date of creating the entity
 * @property Carbon $updatedAt Date of updating the entity
 * @property Carbon $deletedAt Date of deleting the entity
 *
 * @property-read CarMake $carMake Car maker of the car model
 * @property-read Collection|CarTrim[] $carTrims Car trims of the car model
 * @property-read Collection|Listing[] $listings Listings fot the car model
 */
class CarModel extends Model
{
    use CamelCaseForeignKeys;
    use SoftDeletes;

    public const ID = 'id';
    public const MAKE_ID = 'makeId';
    public const NAME = 'name';
    public const YEAR_START = 'yearStart';
    public const YEAR_END = 'yearEnd';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'CarModels';
    
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
        self::NAME,
        self::MAKE_ID,
        self::YEAR_START,
        self::YEAR_END,
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
        self::NAME,
        self::MAKE_ID,
        self::YEAR_START,
        self::YEAR_END,
    ];
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        self::ID,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];
    
    /**
     * Return car maker for the car model.
     *
     * @return BelongsTo
     */
    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class, self::MAKE_ID);
    }
    
    /**
     * Return car trims for the car model.
     *
     * @return HasMany
     */
    public function carTrims(): HasMany
    {
        return $this->hasMany(CarTrim::class, CarTrim::MODEL_ID);
    }
    
    /**
     * Return listings for this car model.
     *
     * @return HasMany
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, Listing::CAR_MODEL_ID);
    }
}
