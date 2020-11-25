<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\Google2FaException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Google2FAVerifiedRequest;
use App\Http\Transformers\Google2FATransformer;
use Dingo\Api\Http\Response;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use Saritasa\LaravelControllers\Responses\AuthSuccess;
use Tymon\JWTAuth\JWTAuth;

/**
 * Controller for validating Google 2FA code.
 */
class Google2FAController extends BaseApiController
{
    /**
     * Google 2FA library.
     *
     * @var Google2FA
     */
    protected $google2FA;
    
    /**
     * JWT auth.
     *
     * @var JWTAuth
     */
    protected $jwtAuth;
    
    /**
     * Google2FAController constructor.
     *
     * @param Google2FATransformer $transformer Transformer for response
     * @param Google2FA $google2FA Google 2FA library
     * @param JWTAuth $jwtAuth JWT auth
     */
    public function __construct(Google2FATransformer $transformer, Google2FA $google2FA, JWTAuth $jwtAuth)
    {
        $this->google2FA = $google2FA;
        $this->jwtAuth = $jwtAuth;
        
        parent::__construct($transformer);
    }
    
    /**
     * @param Google2FAVerifiedRequest $request
     *
     * @return Response
     *
     * @throws Google2FaException
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function verified(Google2FAVerifiedRequest $request): Response
    {
        $verifiedData = $request->getData();
        
        $valid = $this->google2FA->verifyKey($this->user->google2FASecret, $verifiedData->code);
        
        if (!$valid) {
            throw new Google2FaException();
        }
        
        $this->user->setIs2FAPassed(true);
        
        $response  = new AuthSuccess($this->jwtAuth->fromUser($this->jwtAuth->user()));
        
        return $this->response->item($response, $this->transformer);
    }
}
