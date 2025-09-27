<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'description' => 'Can create, edit, and delete users'],
            ['name' => 'manage_roles', 'display_name' => 'Manage Roles', 'description' => 'Can create, edit, and delete roles'],
            ['name' => 'manage_permissions', 'display_name' => 'Manage Permissions', 'description' => 'Can create, edit, and delete permissions'],
            ['name' => 'view_admin_dashboard', 'display_name' => 'View Admin Dashboard', 'description' => 'Can access admin dashboard'],
            ['name' => 'manage_courses', 'display_name' => 'Manage Courses', 'description' => 'Can create, edit, and delete courses'],
            ['name' => 'enroll_courses', 'display_name' => 'Enroll in Courses', 'description' => 'Can enroll in courses'],
            ['name' => 'view_courses', 'display_name' => 'View Courses', 'description' => 'Can view available courses'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create roles
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Full system access'
            ]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'User',
                'description' => 'Regular user with basic access'
            ]
        );

        // Assign permissions to admin role
        $adminPermissions = Permission::whereIn('name', [
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_admin_dashboard',
            'manage_courses',
            'enroll_courses',
            'view_courses'
        ])->get();

        $adminRole->permissions()->sync($adminPermissions->pluck('id'));

        // Assign permissions to user role
        $userPermissions = Permission::whereIn('name', [
            'enroll_courses',
            'view_courses'
        ])->get();

        $userRole->permissions()->sync($userPermissions->pluck('id'));
    }
}
