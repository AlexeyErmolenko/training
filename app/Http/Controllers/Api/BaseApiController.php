<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use League\Fractal\TransformerAbstract;
use Saritasa\Transformers\BaseTransformer;

/**
 * Base API controller, utilizing helpers from Dingo/API package.
 *
 * @property-read User|null $user Authenticated user
 */
abstract class BaseApiController extends Controller
{
    use Helpers;
    use AuthorizesRequests;

    /**
     * Default Fractal/Transformer instance to use
     *
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * Base API controller, utilizing helpers from Dingo/API package.
     *
     * @param TransformerAbstract $transformer Default transformer to apply to handled entity.
     * If not provided, BaseTransformer is used
     *
     * @see BaseTransformer - default transformer
     */
    public function __construct(TransformerAbstract $transformer)
    {
        $this->transformer = $transformer;
    }
}
