<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // User management
            'manage users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',

            // Product management
            'manage products',
            'create products',
            'edit products',
            'delete products',
            'view product details',

            // Category management
            'manage categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Transaction management
            'manage transactions',
            'create transactions',
            'view transactions',
            'delete transactions',

            // Reports
            'view reports',
            'generate reports',

            // Prescription management
            'manage prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',
            'view prescriptions',

            // Other general permissions
            'manage settings',
            'view audit logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $clerkRole = Role::create(['name' => 'clerk']);
        $clerkRole->givePermissionTo([
            'view dashboard',
            'create transactions',
            'view transactions',
            'manage prescriptions',
            'create prescriptions',
            'view prescriptions',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
