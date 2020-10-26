<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Saritasa\LaravelControllers\BaseController;

/**
 * Controller for home page.
 */
class HomeController extends BaseController
{
    /**
     * On Local and Dev environment, redirect to API documentation.
     * Otherwise (staging, production) redirect to frontend URL from config.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        if (App::environment('local', 'development')) {
            URL::forceRootUrl(null);
            return redirect()->to('apidocs');
        }
        return redirect()->to(config('app.url'));
    }

    /**
     * View PHP configuration details. For local development only.
     */
    public function phpinfo(): void
    {
        phpinfo();
    }
}
