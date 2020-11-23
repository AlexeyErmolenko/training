<?php


namespace App\Services;

use App\Dto\UserData;
use App\Models\User;
use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;
use Validator;

class UserManagementService
{
    protected const PREFIX_LOCK = 'user-';
    
    /**
     * Create new user.
     *
     * @param UserData $userData User data from request
     *
     * @return User
     *
     * @throws Throwable
     */
    public function create(UserData $userData): User
    {
        $lock = Cache::lock(self::PREFIX_LOCK . $userData->email, Carbon::SECONDS_PER_MINUTE * 2);
        try {
            $lock->block(Carbon::SECONDS_PER_MINUTE * 2);
            $this->validateUserEmailOnUnique($userData->email);
            
            $user = DB::transaction(function () use ($userData) {
                $user = (new User())->fill($userData->toArray());
                $user->password = $userData->password;
                $user->save();
                return $user;
            });
            
            event(new Registered($user));
            
            return $user;
        } finally {
            $lock->release();
        }
    }
    
    /**
     * Validate user email on unique.
     *
     * @param string $email User email
     * @param User|null $user User object
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function validateUserEmailOnUnique(string $email, ?User $user = null): void
    {
        $rules = [UserData::EMAIL => ['required', 'email', 'max:255']];
        
        if ($user) {
            $rules[UserData::EMAIL][] = Rule::unique('Users', User::EMAIL)->ignore($user->id);
        } else {
            $rules[UserData::EMAIL][] = Rule::unique('Users', User::EMAIL);
        }

        $validator = Validator::make([UserData::EMAIL => $email], $rules);

        if ($validator->errors()->isNotEmpty()) {
            throw new ValidationException($validator);
        }
    }
}
