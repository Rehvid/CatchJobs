<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\AuthRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmployerRequest;
use App\Providers\RouteServiceProvider;
use App\Services\RegisterEmployerService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisteredEmployerController extends Controller
{
    public function create(): View
    {
        return view('auth.register-employer');
    }

    public function store(EmployerRequest $request, RegisterEmployerService $registerEmployerService): RedirectResponse
    {
        $user = $registerEmployerService->createUser($request->validated());
        $employerRole = Role::findByName(AuthRole::EMPLOYER->value);
        $registerEmployerService->createCompanyForEmployer($request->validated(), $user->id);
        $user->assignRole($employerRole);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
