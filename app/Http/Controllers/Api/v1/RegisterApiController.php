<?php


namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Transformers\UserTransformer;
use App\Services\UserManagementService;
use Dingo\Api\Http\Response;
use Saritasa\LaravelControllers\Api\BaseApiController;

class RegisterApiController extends BaseApiController
{
    public function register(
        RegisterUserRequest $request,
        UserManagementService $service,
        UserTransformer $transformer
    ): Response {
        $user = $service->create($request->getUserData());
        
        return new Response(['user' => $transformer->transform($user)], Response::HTTP_CREATED);
    }
}
