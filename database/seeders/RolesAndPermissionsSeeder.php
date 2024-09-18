<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions

        // User permissions
        Permission::create(['name' => 'add vehicles']);
        Permission::create(['name' => 'post feedback']);
        Permission::create(['name' => 'add prices']);
        Permission::create(['name' => 'create tickets']);

        // Station Manager permissions
        Permission::create(['name' => 'add stations']);

        // Admin permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage station managers']);
        Permission::create(['name' => 'answer tickets']);
        Permission::create(['name' => 'approve sections']);
        Permission::create(['name' => 'reject sections']);
        Permission::create(['name' => 'update sections']);
        Permission::create(['name' => 'delete sections']);

        // Super Admin permissions (will be assigned all permissions)
        // Alternatively, we can use Gate::before to grant all abilities

        // Create roles and assign existing permissions

        // User role
        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo(['add vehicles', 'post feedback', 'add prices', 'create tickets']);

        // Station Manager role
        $stationManagerRole = Role::create(['name' => 'Station Manager']);
        $stationManagerRole->givePermissionTo(['add stations', 'create tickets']);

        // Admin role
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'manage users',
            'manage station managers',
            'answer tickets',
            'approve sections',
            'reject sections',
            'update sections',
            'delete sections',
        ]);

        // Super Admin role
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());
    }
}
