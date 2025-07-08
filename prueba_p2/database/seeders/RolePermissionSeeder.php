<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'access.system']);
        Permission::create(['name' => 'manage.users']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(['access.system', 'manage.users']);
        $userRole->givePermissionTo('access.system');

        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'), // Use a secure password
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        $admin->assignRole('admin');
    }
}
