<?php

namespace App\Http\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transforms user into appropriate api response.
     *
     * @param User $user User object
     *
     * @return mixed[]
     */
    public function transform(User $user): array
    {
        return [
            User::ID => $user->id,
            User::FIRST_NAME => $user->firstName,
            User::LAST_NAME => $user->lastName,
            User::EMAIL => $user->email,
            User::AVATAR => $user->avatarUrl,
        ];
    }
}
