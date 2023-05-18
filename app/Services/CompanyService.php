<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Benefit;
use App\Models\Company;
use App\Models\File;
use App\Models\Industry;
use App\Models\Location;
use App\Models\Social;
use App\Models\SocialNetwork;
use Illuminate\Http\UploadedFile;
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
        $this->handleActionsForCompany();
    }

    public function editCompany(array $companyData, Company $company): void
    {
        $this->transformValidatedCompanyDataToCollection($companyData);
        $this->company = $company;
        $this->updateCompany();
        $this->handleActionsForCompany();
    }

    private function updateCompany(): void
    {
        $this->company->update($this->companyCollection->toArray());
    }

    private function handleActionsForCompany(): void
    {
        $this->syncBenefitsForCompany();
        $this->handleSocialsForCompany();
        $this->handleUploadedImagesForCompany();
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

        if ($this->companyCollection->get('location_id') === 0) {
            $this->companyCollection->put('location_id', $this->createLocationForCompany()->id);
        }

    }

    private function putDataToCompanyCollection(): void
    {
        $this->companyCollection->put('user_id', Auth::user()->id);
        $this->companyCollection->put('slug', Str::slug($this->companyCollection->get('name')));
        if (isset($this->company) && !$this->isSubmittedLocationEqualToCompanyLocation()) {
            $this->company->location_id = $this->companyCollection->get('location_id');
            $this->updateLocationForCompany();
        }
    }

    private function isSubmittedLocationEqualToCompanyLocation(): bool
    {
        return !is_null($this->company->location_id)
            && $this->company->location_id === $this->companyCollection->get('location_id');
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

    private function createLocationForCompany(): Location
    {
        return Location::create($this->companyCollection->toArray());
    }

    private function updateLocationForCompany(): void
    {
        $this->company->location?->update($this->companyCollection->all());
    }

    private function handleSocialsForCompany(): void
    {
        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

         $socialNetworks->each(function (string $name, int $id)  {
             $social = $this->company->socials->find($id);
             $url = $this->companyCollection->get($name);

             if ($social) {
                 is_null($url) === true
                     ? $this->deleteSocialForCompany($social)
                     : $this->updateSocialForCompany($social);

                 return;
             }

             if (!is_null($url)) {
                 $this->createSocialForCompany((string) $url, $id);
             }
         });
    }

    private function deleteSocialForCompany(Social $social): void
    {
        $social->delete();
    }

    private function updateSocialForCompany(Social $social): void
    {
        $social->update([
            'url' => $this->companyCollection->get($social->socialNetwork->name)
        ]);
    }

    private function createSocialForCompany(string $url, int $socialId): void
    {
        Social::create([
            'company_id' => $this->company->id,
            'social_network_id' => $socialId,
            'url' => $url
        ]);
    }

    private function handleUploadedImagesForCompany(): void
    {
        $images = $this->companyCollection->filter(function(mixed $value, string $key) {
            return Str::startsWith($key, 'image') && $value !== null;
        });

        $images->each(function(mixed $image, string $key){
            $collection = Str::after($key, 'image_');
            is_array($image) === true
                ? $this->storeMultipleImagesForCompany($collection, images: $image)
                : $this->storeImageForCompany($collection, $image);
        });

    }

    private function storeMultipleImagesForCompany(string $collection, array $images): void
    {
        foreach ($images as $image) {
            $this->storeImageForCompany($collection, $image);
        }
    }

    private function storeImageForCompany(string $collection, UploadedFile $uploadedImage): void
    {
        $uploadedImage->store($collection, config('app.uploads.disk'));
        $file = $this->createImage($collection, $uploadedImage);
        $this->company->files()->attach($file->id);
    }

    private function createImage(string $collection, UploadedFile $uploadedImage): File
    {
        $path = $collection . '/' . $uploadedImage->hashName();

        return File::create([
            'name' => $uploadedImage->hashName(),
            'disk' => config('app.uploads.disk'),
            'path' => $path,
            'mime_type' => $uploadedImage->getClientMimeType(),
            'collection' => $collection,
        ]);
    }
}
