<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Company\ImageDestroyRequest;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\File;
use App\Models\Location;
use App\Models\SocialNetwork;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
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

        $this->companyService->transformValidatedCompanyDataToCollection($request->validated());
        $company = $this->companyService->createCompany();
        $this->companyService->syncBenefitsForCompany($company);
        $this->companyService->handleSocialsForCompany($company);
        $this->companyService->handleUploadedImagesForCompany($company);

        return redirect()->route('companies.list')->with('success', __('company.success.store'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Company $company)
    {
        $this->authorize('update', $company);

        $company->load('benefits', 'socials', 'files');
        $user = Auth::user();

        $locations = Location::when(
            !$user->isAdmin(), fn($query) => $query->byUser()
        )->get();

        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        $data = [
            'locations',
            'company',
            'socialNetworks'
        ];

        return view('company.form', compact($data));
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        $this->companyService->transformValidatedCompanyDataToCollection($request->validated());
        $this->companyService->updateCompany($company);
        $this->companyService->syncBenefitsForCompany($company);
        $this->companyService->handleSocialsForCompany($company);
        $this->companyService->handleUploadedImagesForCompany($company);

        return redirect()->route('companies.list')->with('success', __('company.success.update'));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        $this->companyService->destroySocialsForCompany($company);
        $this->companyService->destroyFilesForCompany($company);
        $this->companyService->destroyBenefitsForCompany($company);
        $this->companyService->destroyCompany($company);

        return redirect()->route('companies.list')->with('success', __('company.success.destroy'));
    }

    public function destroyImage(ImageDestroyRequest $request): JsonResponse
    {
        $this->authorize('delete', Company::find($request->validated('company_id')));

        return response()->json([
            'status' => $this->companyService->destroyImageForCompany(
                File::find($request->validated('id'))
            )
        ]);
    }
}
