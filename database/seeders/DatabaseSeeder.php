<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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

            // company setting
            ['name' => 'view company_setting', 'guard_name' => 'web'],
            ['name' => 'edit company_setting', 'guard_name' => 'web'],

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

            //Attendance 
            // Permission
            ['name' => 'create attendance', 'guard_name' => 'web'],
            ['name' =>'attendance overview', 'guard_name'=>'web'],
            ['name' => 'view attendance', 'guard_name' => 'web'],
            ['name' => 'edit attendance', 'guard_name' => 'web'],
            ['name' => 'delete attendance', 'guard_name' => 'web'],
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
        User::factory()->create(['name' => 'hradmin', 'email' => 'admin@gmail.com', 'password' => 'admin@gmail.com', 'pin_code' => Hash::make('123456')])->syncRoles($adminRole);
        User::factory()->count(5)->create();
        
        if (CompanySetting::count() === 0) {
            CompanySetting::create([
                'company_name' => 'brnyr',
                'email' => 'brnyr@email.com',
                'company_phone' => '09118277736',
                'company_address' => 'No(67) Brnyr Street, Brnyr TownShip, BrNyr Town',
                'office_start_time' => '09:00:00', 
                'office_end_time' => '17:00:00',
                'break_start_time' => '12:00:00', 
                'break_end_time' => '13:00:00'
            ]);
        }

        $users = User::all();
        foreach($users as $user){
            $currentDate = Carbon::now();
            // $startDate = $currentDate->copy()->startOfMonth();
            $startDate = $currentDate->copy()->subMonths(3)->startOfMonth();
            $endDate = $currentDate->copy()->endOfMonth();
            $periods = new CarbonPeriod($startDate, $endDate);
            foreach($periods as $period){
                CheckinCheckout::create([
                    'user_id' => $user->id,
                    'date' => $period->format('Y-m-d'),
                    'checkin_time' =>  Carbon::createFromTime(8, 30, 0)->addMinutes(rand(1, 60)),
                    'checkout_time' => Carbon::createFromTime(16, 30, 0)->addMinutes(rand(1,60))
                ]);
            }
        }
    }
}
