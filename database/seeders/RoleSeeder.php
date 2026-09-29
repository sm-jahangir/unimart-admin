<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the default roles.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin', 'deletable' => false],
        )->permissions()->sync(Permission::all()->pluck('id'));

        Role::updateOrCreate(
            ['slug' => 'user'],
            ['name' => 'User', 'deletable' => false],
        );
    }
}
