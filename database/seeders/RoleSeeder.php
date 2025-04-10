<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

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
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $clerkRole = Role::updateOrCreate(['id' => 1], ['name' => 'clerk']);
        $clerkRole->givePermissionTo([
            'view dashboard',
            'create transactions',
            'view transactions',
            'manage prescriptions',
            'create prescriptions',
            'view prescriptions',
        ]);

        $adminRole = Role::updateOrCreate(['id' => 2], ['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());


        $patientRole = Role::updateOrCreate(['id' => 3], ['name' => 'patient']);
        $patientRole->givePermissionTo([
            'view dashboard'
        ]);

        // Create admin user and assign admin role
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
            ]
        );
        $adminUser->role_id = 2;
        $adminUser->save();
        $adminUser->assignRole($adminRole);

        // Create clerk user and assign clerk role
        $clerkUser = User::firstOrCreate(
            ['email' => 'clerk@gmail.com'],
            [
                'name' => 'Clerk User',
                'password' => Hash::make('12345678'),
            ]
        );
        $clerkUser->role_id = 1;
        $clerkUser->save();
        $clerkUser->assignRole($clerkRole);
    }
}
