<?php

use Saritasa\Roles\Enums\Roles;

/**
 * Adds admin user row.
 */
class AddAdminUser extends MigrationWithQueryBuilder
{
    protected const ADMIN_EMAIL = 'admin@mail.com';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->newQuery('users')
            ->insert([
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => static::ADMIN_EMAIL,
                'role_id' => $this->newQuery('roles')->find(Roles::ADMIN)->id ?? null,
                'password' => password_hash('123456', PASSWORD_DEFAULT),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $user = $this->newQuery('users')->where(['email' => static::ADMIN_EMAIL])->first(['id']);

        if ($user) {
            $this->newQuery('users')->delete($user->id);
        }
    }
}
