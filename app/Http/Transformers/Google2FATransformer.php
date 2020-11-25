<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Saritasa\LaravelControllers\Responses\AuthSuccess;

class Google2FATransformer extends TransformerAbstract
{
    /**
     * Transforms auth into appropriate api response.
     *
     * @param AuthSuccess $auth Auth data.
     *
     * @return mixed[]
     */
    public function transform(AuthSuccess $auth): array
    {
        return $auth->toArray();
    }
}
