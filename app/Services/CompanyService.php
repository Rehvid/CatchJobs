<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Benefit;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyService
{
    private Collection $companyCollection;
    private readonly Company $company;

    public function storeCompany(array $companyData): void
    {
        $this->transformValidatedCompanyDataToCollection($companyData);
        $this->company = $this->createCompany();
        $this->syncBenefitsForCompany();
    }

    private function transformValidatedCompanyDataToCollection($companyData): void
    {
        $this->companyCollection = collect($companyData);
        $this->putDataToCompanyCollection();

        if ($this->companyCollection->get('benefits')) {
            $this->transformBenefitsForCompanyCollection();
        }

        if ($this->companyCollection->get('industry')) {
            $this->transformIndustryForCompanyCollection();
        }
    }

    private function putDataToCompanyCollection(): void
    {
        $this->companyCollection->put('user_id', Auth::user()->id);
        $this->companyCollection->put('slug', Str::slug($this->companyCollection->get('name')));
    }

    private function transformBenefitsForCompanyCollection(): void
    {
        $benefits = $this->companyCollection->get('benefits');
        $benefitIds = [];

        foreach ($benefits as ['value' => $benefit]) {
            $benefitId = Benefit::byName($benefit)->value('id');
            if ($benefitId) {
                $benefitIds[] = $benefitId;
            }
        }

        $this->companyCollection->put('benefits', $benefitIds);
    }

    private function transformIndustryForCompanyCollection(): void
    {
        $industry = $this->companyCollection->get('industry');

        $this->companyCollection->pull('industry');
        $this->companyCollection->put('industry_id', Industry::findByName($industry)->value('id'));
    }


    private function createCompany(): Company
    {
        return Company::create($this->companyCollection->toArray());
    }

    private function syncBenefitsForCompany(): void
    {
       $this->company->benefits()->sync($this->companyCollection->get('benefits'));
    }
}