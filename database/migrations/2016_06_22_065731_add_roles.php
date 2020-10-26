<?php

use Saritasa\Roles\Enums\Roles;

/**
 * Adds admin role row.
 */
class AddRoles extends MigrationWithQueryBuilder
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->newQuery('roles')->insert([
            'id' => Roles::USER,
            'name' => 'User',
            'slug' => 'user',
        ]);
        $this->newQuery('roles')->insert([
            'id' => Roles::ADMIN,
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $roles = $this->newQuery('roles')->whereIn('id', Roles::getConstants())->get(['id']);
        foreach ($roles as $role) {
            $this->newQuery('roles')->delete($role->id);
        }
    }
}
