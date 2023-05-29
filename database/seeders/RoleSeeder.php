<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        Role::create(['name' => UserRole::ADMIN->value]);
        Role::create(['name' => UserRole::EMPLOYER->value]);
        Role::create(['name' => UserRole::USER->value]);
    }
}
