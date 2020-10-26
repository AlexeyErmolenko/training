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
use Saritasa\LaravelUploads\Http\Controllers\UploadsApiController;

/**
 * Api router instance.
 *
 * @var Router $api
 */
$api = app(Router::class);
$api->version(config('api.version'), ['middleware' => 'bindings'], function (Router $api) {
    $api->post('auth', JWTAuthApiController::class.'@login');
    $api->put('auth', JWTAuthApiController::class.'@refreshToken');

    $api->post('auth/password/reset', ForgotPasswordApiController::class.'@sendResetLinkEmail');
    $api->put('auth/password/reset', ResetPasswordApiController::class.'@reset');

    $api->get('/testPdf', \App\Http\Controllers\PdfController::class.'@download');

    // Group of routes that require authentication
    $api->group(['middleware' => ['api.auth']], function (Router $api) {
        $api->delete('auth', JWTAuthApiController::class.'@logout');
    });
});
