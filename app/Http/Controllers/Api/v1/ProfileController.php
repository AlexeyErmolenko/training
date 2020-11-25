<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Transformers\UserTransformer;

use Dingo\Api\Http\Response;

/**
 * Controller for working with profile data.
 */
class ProfileController extends BaseApiController
{
    /**
     * Controller for working with profile data
     *
     * @param UserTransformer $transformer Transformer for response
     */
    public function __construct(UserTransformer $transformer)
    {
        parent::__construct($transformer);
    }
    
    /**
     * Get data about a current profile.
     *
     * @return Response
     */
    public function me(): Response
    {
        return $this->response->item($this->user,$this->transformer);
    }
    
}
