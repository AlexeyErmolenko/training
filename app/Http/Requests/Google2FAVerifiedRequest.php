<?php

namespace App\Http\Requests;

use App\Dto\Google2FAVerifiedData;

/**
 * Request with Google 2FA code data.
 */
class Google2FAVerifiedRequest extends Request
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Google2FAVerifiedData::CODE => [
                'required',
                'string',
                'min:6',
                'max:6',
            ],
        ];
    }
    
    /**
     * Get request data.
     *
     * @return Google2FAVerifiedData
     */
    public function getData(): Google2FAVerifiedData
    {
        return new Google2FAVerifiedData($this->validate($this->rules()));
    }
}
