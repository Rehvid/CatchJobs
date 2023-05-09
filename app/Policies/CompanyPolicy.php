<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->can('company.list');
    }

    public function create(User $user): bool
    {
        return $user->can('company.store');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->can('company.update') && $this->hasPermissionsToAction($user, $company);
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->can('company.destroy') && $this->hasPermissionsToAction($user, $company);
    }

    private function hasPermissionsToAction(User $user, Company $company): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $company->user_id;
    }

}
