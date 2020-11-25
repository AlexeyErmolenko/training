<?php

namespace App\Http\Transformers;

use App\Models\User;

class RegisterUserTransformer extends UserTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user): array
    {
        return array_merge(
            parent::transform($user),
            ['qrCodeImage' => $user->getQrCodeImage()]
        );
    }
}
