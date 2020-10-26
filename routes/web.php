<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SwaggerController;
use Illuminate\Routing\Router;

$router = app('router');

$router->namespace('App\\Http\\Controllers')->group(function(Router $router) {
    $router->auth([
        'reset' => true,
        'verify' => true,
    ]);
});

$router->get('/swagger', SwaggerController::class."@index");
$router->get('/apidocs', SwaggerController::class."@apidocs");
$router->any('/', HomeController::class . '@index');
if (app()->isLocal()) {
    $router->get('phpinfo', HomeController::class.'@phpinfo');
}
