<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Location;
use App\Models\SocialNetwork;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class CompanyController extends Controller
{

    public function __construct(private readonly CompanyService $companyService){}

    public function index()
    {
    }

    public function list(): View
    {
        $this->authorize('viewAny', Company::class);

        $user = Auth::user();

        $companies = Company::when(
                !$user->isAdmin(), fn($query) => $query->byUser($user->id)
            )
            ->simplePaginate();

        return view('company.list', ['companies' => $companies]);
    }

    public function create(): View
    {
        $this->authorize('create', Company::class);
        $user = Auth::user();

        $locations = Location::when(
            !$user->isAdmin(), fn($query) => $query->byUser()
        )->get();

        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        return view('company.form', compact('locations', 'socialNetworks'));
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $this->authorize('create', Company::class);

        $this->companyService->storeCompany($request->validated());

        return redirect()->route('companies.list')->with('success', __('company.success.store'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Company $company)
    {
        $company->load('benefits', 'socials', 'files');
        $user = Auth::user();

        $locations = Location::when(
            !$user->isAdmin(), fn($query) => $query->byUser()
        )->get();

        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        return view('company.form', compact('locations', 'company', 'socialNetworks'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
