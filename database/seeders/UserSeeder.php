<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::findByName(UserRole::ADMIN->value);
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $userRole = Role::findByName(UserRole::USER->value);

        $admin = User::create([
            'name' => 'Admin admin',
            'email' => 'admin@admin',
            'password' => Hash::make('admin'),
            'phone' => '123456789',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $admin->assignRole($adminRole);

        $employer = User::create([
            'name' => 'Employer employer',
            'email' => 'employer@employer',
            'password' => Hash::make('employer'),
            'phone' => '123456788',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $employer->assignRole($employerRole);

        $user = User::create([
            'name' => 'user user',
            'email' => 'user@user',
            'password' => Hash::make('user'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $user->assignRole($userRole);
    }
}
