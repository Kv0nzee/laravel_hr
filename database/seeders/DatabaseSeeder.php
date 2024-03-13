<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Department::insert([
            ['title' => 'Web Development', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mobile Development', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Operation', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Permission::insert([

            //profile
            ['name' => 'edit profile', 'guard_name' => 'web'],
            ['name' => 'view profile', 'guard_name' => 'web'],

            // Employees
            ['name' => 'create employees', 'guard_name' => 'web'],
            ['name' => 'view employees', 'guard_name' => 'web'],
            ['name' => 'edit employees', 'guard_name' => 'web'],
            ['name' => 'delete employees', 'guard_name' => 'web'],
        
            // Roles
            ['name' => 'create roles', 'guard_name' => 'web'],
            ['name' => 'view roles', 'guard_name' => 'web'],
            ['name' => 'edit roles', 'guard_name' => 'web'],
            ['name' => 'delete roles', 'guard_name' => 'web'],
        
            // Departments
            ['name' => 'create departments', 'guard_name' => 'web'],
            ['name' => 'view departments', 'guard_name' => 'web'],
            ['name' => 'edit departments', 'guard_name' => 'web'],
            ['name' => 'delete departments', 'guard_name' => 'web'],

            // Permission
            ['name' => 'create permissions', 'guard_name' => 'web'],
            ['name' => 'view permissions', 'guard_name' => 'web'],
            ['name' => 'edit permissions', 'guard_name' => 'web'],
            ['name' => 'delete permissions', 'guard_name' => 'web'],
        ]);

        Role::insert([
            //profile
            ['name' => 'HR', 'guard_name' => 'web'],
            ['name' => 'Manager', 'guard_name' => 'web'],
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'User', 'guard_name' => 'web'],
        ]);


        $roles = Role::all();
        foreach ($roles as $role) {
            $userDefaultPermissions = Permission::whereIn('name', ['edit profile', 'view profile'])->pluck('id');
            $role->syncPermissions($userDefaultPermissions);
        }

        // Assign all permissions to the 'Admin' role
        $permissions = Permission::pluck('id')->all();
        $adminRole = Role::where('name', 'Admin')->first();
        $adminRole->syncPermissions($permissions);
        User::factory()->count(10)->create();
        $user = User::factory()->create(['name' => 'hradmin', 'email' => 'admin@gmail.com', 'password' => 'admin@gmail.com'])->syncRoles($adminRole);
    }
}
