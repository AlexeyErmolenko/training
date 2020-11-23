<?php

namespace App\Http\Requests;

use App\Dto\UserData;
use Saritasa\LaravelUploads\Services\UploadsService;

/**
 * Request with user data.
 */
class EditUserRequest extends Request
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            UserData::FIRST_NAME => ['required', 'string', 'max:100'],
            UserData::LAST_NAME => ['required', 'string', 'max:100'],
            UserData::EMAIL => ['required', 'email', 'max:255'],
            UserData::AVATAR => ['nullable', 'string', 'url'],
        ];
    }
    
    /**
     * Get user data from request.
     *
     * @return UserData
     */
    public function getUserData(): UserData
    {
        $user = new UserData($this->validate($this->rules()));
        $user->avatarUrl = !$user->avatarUrl ? null : app(UploadsService::class)->getPathFromUrl($user->avatarUrl);
        
        return $user;
    }
}
