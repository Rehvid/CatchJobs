<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyRequest;
use App\Http\Requests\Company\ImageDestroyRequest;
use App\Models\Company;
use App\Models\File;
use App\Models\Location;
use App\Models\SocialNetwork;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class CompanyController extends Controller
{

    public function __construct(private readonly CompanyService $companyService){}

    public function index(): View
    {
        $companies = Company::with('benefits','socials', 'files')->accepted()->paginate(16);

        return view('company.index', compact('companies'));
    }

    public function list(): View
    {
        $this->authorize('viewAny', Company::class);

        $companies = Company::byUser()->paginate(16);

        return view('company.list', compact('companies'));
    }

    public function create(): View
    {
        $this->authorize('create', Company::class);

        $locations = Location::byUser()->get();
        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        return view('company.form', compact('locations', 'socialNetworks'));
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $this->authorize('create', Company::class);

        $this->companyService->transformValidatedCompanyDataToCollection($request->validated());
        $this->companyService->handleLocationForCompany();
        $company = $this->companyService->createCompany();
        $this->companyService->syncBenefitsForCompany($company);
        $this->companyService->handleSocialsForCompany($company);
        $this->companyService->handleUploadedImagesForCompany($company);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.companies.list')->with('success', __('company.success.store'));
        }

        return redirect()->route('companies.list')->with('success', __('company.success.store'));
    }

    public function show(Company $company): View
    {
        $company->load('benefits', 'socials', 'files');

        return view('company.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        $this->authorize('update', $company);

        $company->load('benefits', 'socials', 'files');
        $locations = Location::byUser()->get();
        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        return view('company.form', compact([
            'company',
            'locations',
            'socialNetworks'
        ]));
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        $this->companyService->transformValidatedCompanyDataToCollection($request->validated());
        $this->companyService->handleLocationForCompany($company);
        $this->companyService->updateCompany($company);
        $this->companyService->syncBenefitsForCompany($company);
        $this->companyService->handleSocialsForCompany($company);
        $this->companyService->handleUploadedImagesForCompany($company);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.companies.list')->with('success', __('company.success.update'));
        }

        return redirect()->route('companies.list')->with('success', __('company.success.update'));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        $this->companyService->destroySocialsForCompany($company);
        $this->companyService->destroyFilesForCompany($company);
        $this->companyService->destroyBenefitsForCompany($company);
        $this->companyService->destroyCompany($company);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.companies.list')->with('success', __('company.success.destroy'));
        }

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
