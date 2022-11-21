<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'add-trend']);
        Permission::create(['name' => 'edit-trend']);
        Permission::create(['name' => 'delete-trend']);

        Permission::create(['name' => 'add-term']);
        Permission::create(['name' => 'edit-term']);
        Permission::create(['name' => 'delete-term']);

        Permission::create(['name' => 'add-permissions']);
        Permission::create(['name' => 'edit-permissions']);
        Permission::create(['name' => 'delete-permissions']);

        Permission::create(['name' => 'add-roles']);
        Permission::create(['name' => 'edit-roles']);
        Permission::create(['name' => 'delete-roles']);

        $adminRole = Role::create(['name' => 'Admin']);
        $smeRole = Role::create(['name' => 'SME']);
        $moderatorRole = Role::create(['name' => 'Moderator']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',

            'add-term',
            'edit-term',
            'delete-term',

            'add-trend',
            'edit-trend',
            'delete-trend',

            'add-permissions',
            'edit-permissions',
            'delete-permissions',

            'add-roles',
            'edit-roles',
            'delete-roles'
        ]);

        $smeRole->givePermissionTo([
            'add-term',
            'edit-term',
            'delete-term',

            'add-trend',
            'edit-trend',
            'delete-trend',

            'edit-permissions',
            'edit-roles'
        ]);

        $moderatorRole->givePermissionTo([
            'add-term',
            'add-trend'
        ]);
    }
}
