<?php

namespace App\Models;

use App\Models\Helpers\CamelCaseForeignKeys;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
  * Model for entity car trims.
  *
  * @property int $id Car trim identifier
  * @property int $modelId Car model identifier
  * @property string $name  Name of the car trim
  * @property Carbon $createdAt Date of creating the entity
  * @property Carbon $updatedAt Date of updating the entity
  * @property Carbon $deletedAt Date of deleting the entity
 */
class CarTrim extends Model
{
    use CamelCaseForeignKeys;
    use SoftDeletes;

    public const ID = 'id';
    public const NAME = 'name';
    public const MODEL_ID = 'modelId';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'CarTrims';
    
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
        self::MODEL_ID,
        self::NAME,
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
        self::MODEL_ID,
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
}
