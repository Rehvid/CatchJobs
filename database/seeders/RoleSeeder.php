<?php

namespace Database\Seeders;

use App\Enums\AuthRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        Role::create(['name' => AuthRole::ADMIN->value]);
        Role::create(['name' => AuthRole::EMPLOYER->value]);
        Role::create(['name' => AuthRole::USER->value]);
    }
}
