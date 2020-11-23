<?php

namespace App\Http\Requests;

use App\Dto\UserData;
use Illuminate\Validation\Rule;

/**
 * Request with register data.
 */
class RegisterUserRequest extends EditUserRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            UserData::PASSWORD => [
                'required',
                'string',
                'min:6',
            ],
            UserData::EMAIL => ['required', 'email', 'max:255', Rule::unique('Users', 'email')],
        ]);
    }
}
