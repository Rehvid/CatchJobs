<?php
declare(strict_types=1);
namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterEmployerService
{
    public function createUser(array $userData): User
    {
        return User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'phone' => $userData['phone'],
        ]);
    }

    public function createCompanyForEmployer(array $companyData, int $userId): Company
    {
        return Company::create([
            'user_id' => $userId,
            'name' => $companyData['company_name'],
            'vat_number' => $companyData['vat_number'],
            'slug' => Str::slug($companyData['company_name'])
        ]);
    }
}
