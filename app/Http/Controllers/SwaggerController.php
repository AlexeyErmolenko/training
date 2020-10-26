<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Saritasa\LaravelControllers\BaseController;

/**
 * Controller for swagger documentation page.
 */
class SwaggerController extends BaseController
{
    /**
     * Swagger documentation page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('swagger.index', [
            'checksum' => md5_file(base_path('public/swagger-ui/api.yaml')),
        ]);
    }

    public function apidocs(): RedirectResponse
    {
        URL::forceRootUrl(null);
        return redirect()->to('swagger-ui?url=api.yaml?'.md5_file(base_path('public/swagger-ui/api.yaml')));
    }
}
