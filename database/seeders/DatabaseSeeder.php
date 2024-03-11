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
            ['name' => 'create employee', 'guard_name' => 'web'],
            ['name' => 'view employee', 'guard_name' => 'web'],
            ['name' => 'edit employee', 'guard_name' => 'web'],
            ['name' => 'delete employee', 'guard_name' => 'web'],
        
            // Roles
            ['name' => 'create role', 'guard_name' => 'web'],
            ['name' => 'view role', 'guard_name' => 'web'],
            ['name' => 'edit role', 'guard_name' => 'web'],
            ['name' => 'delete role', 'guard_name' => 'web'],
        
            // Departments
            ['name' => 'create department', 'guard_name' => 'web'],
            ['name' => 'view department', 'guard_name' => 'web'],
            ['name' => 'edit department', 'guard_name' => 'web'],
            ['name' => 'delete department', 'guard_name' => 'web'],
        ]);

        Role::insert([
            //profile
            ['name' => 'HR', 'guard_name' => 'web'],
            ['name' => 'Manager', 'guard_name' => 'web'],
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Worker', 'guard_name' => 'web'],
        ]);

        User::factory()->count(10)->create();
    }
}
