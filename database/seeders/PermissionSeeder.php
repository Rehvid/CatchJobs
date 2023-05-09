<?php

namespace Database\Seeders;

use App\Enums\AuthRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        $adminRole = Role::findByName(AuthRole::ADMIN->value);
        $employerRole = Role::findByName(AuthRole::EMPLOYER->value);

        Permission::create(['name' => 'company.list']);
        Permission::create(['name' => 'company.store']);
        Permission::create(['name' => 'company.destroy']);
        Permission::create(['name' => 'company.update']);

        $adminRole->givePermissionTo([
            'company.list',
            'company.store',
            'company.destroy',
            'company.update'
        ]);

        $employerRole->givePermissionTo([
            'company.list',
            'company.store',
            'company.destroy',
            'company.update'
        ]);
    }
}
