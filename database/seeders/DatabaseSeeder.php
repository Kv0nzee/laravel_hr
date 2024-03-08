<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        User::factory()->count(10)->create();
    }
}
