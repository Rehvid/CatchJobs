<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
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
        $user = Auth::user();

        $companies = Company::when(
                !$user->isAdmin(), fn($query) => $query->byUser($user->id)
            )
            ->simplePaginate();

        return view('company.list', ['companies' => $companies]);
    }

    public function create(): View
    {
        return view('company.create');
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $this->companyService->storeCompany($request->validated());

        return redirect()->route('companies.list')->with('success', __('company.success.store'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
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
