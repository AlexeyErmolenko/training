<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Dingo\Api\Routing\Router;
use Saritasa\LaravelControllers\Api\JWTAuthApiController;
use Saritasa\LaravelControllers\Api\ForgotPasswordApiController;
use Saritasa\LaravelControllers\Api\ResetPasswordApiController;
use App\Http\Controllers\Api\v1\RegisterApiController;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\Google2FAController;

/**
 * Api router instance.
 *
 * @var Router $api
 */
$api = app(Router::class);
$api->version(config('api.version'), ['middleware' => 'bindings'], function (Router $api) {
    $api->post('auth', JWTAuthApiController::class.'@login');
    $api->put('auth', JWTAuthApiController::class.'@refreshToken');
    
    $api->post('users', RegisterApiController::class . '@register');

    $api->post('auth/password/reset', ForgotPasswordApiController::class.'@sendResetLinkEmail');
    $api->put('auth/password/reset', ResetPasswordApiController::class.'@reset');

    // Group of routes that require authentication
    $api->group(['middleware' => ['api.auth']], function (Router $api) {
        $api->post('auth/2fa', Google2FAController::class . '@verified');
        
        $api->delete('auth', JWTAuthApiController::class . '@logout');
        
        $api->group(['middleware' => ['2fa']], function (Router $api) {
            $api->get('users/me', ProfileController::class . '@me');
        });
    
    });
});
