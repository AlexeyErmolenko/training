<?php

namespace App\Http\Middleware;

use App\Exceptions\Google2FaException;
use App\Models\User;
use Closure;
use Tymon\JWTAuth\Claims\Custom;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class Google2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request Current request
     * @param  Closure  $next Next middleware function
     *
     * @return mixed
     *
     * @throws Google2FaException
     */
    public function handle(Request $request, Closure $next)
    {
        /* @var ?Custom $is2FAPassed */
        $is2FAPassed = JWTAuth::getPayload()->getClaims()->get(User::IS_2_FA_PASSED);
        
        if (
            empty($is2FAPassed) ||
            ($is2FAPassed instanceof Custom && empty($is2FAPassed->getValue()))
        ) {
            throw new Google2FaException();
        }
        
        return $next($request);
    }
}
