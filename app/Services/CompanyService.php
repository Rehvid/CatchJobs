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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyService
{
    private Collection $companyCollection;
    private array $fileIds = [];



    public function transformValidatedCompanyDataToCollection(array $companyData): void
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

    public function createCompany(): Company
    {
        return Company::create($this->companyCollection->toArray());
    }

    public function updateCompany(Company $company): void
    {
        $company->update($this->companyCollection->toArray());
    }


    public function syncBenefitsForCompany(Company $company): void
    {
        $company->benefits()->sync($this->companyCollection->get('benefits'));
    }

    public function handleSocialsForCompany(Company $company): void
    {
        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        $socialNetworks->each(function (string $name, int $socialNetworkId) use ($company)  {
            $social = $company->socialByNetworkId($socialNetworkId);
            $url = $this->companyCollection->get($name);

            if ($url) {
                $socialDataToFind = ['id' => $social->id ?? null];
                $socialData = [
                    'company_id' => $company->id,
                    'social_network_id' => $socialNetworkId,
                    'url' => $url
                ];
                $this->updateOrCreateSocialForCompany($socialDataToFind, $socialData);

                return;
            }

            if ($social) {
                $this->deleteSocialForCompany($social);
            }
        });
    }

    public function handleUploadedImagesForCompany(Company $company): void
    {

        $images = $this->companyCollection->filter(function(mixed $value, string $key) {
            return Str::startsWith($key, 'image_') && $value !== null;
        });

        $images->each(function(mixed $image, string $key){
            $collection = Str::after($key, 'image_');

            is_array($image)
                ? $this->storeMultipleImagesForCompany($collection, images: $image)
                : $this->storeImageForCompany($collection, $image);
        });

        $this->attachFilesToCompany($company);
    }

    public function destroySocialsForCompany(Company $company): void
    {
        $company->socials?->each(fn(Social $social) => $this->deleteSocialForCompany($social));
    }

    public function destroyFilesForCompany(Company $company): void
    {
        $company->files?->each(function (File $file) {
            if (Storage::disk(config('app.uploads.disk'))->exists($file->path)) {
                $this->destroyImageForCompany($file);
            }
        });

    }

    public function destroyImageForCompany(File $file): ?bool
    {
        Storage::disk(config('app.uploads.disk'))->delete($file->path);
        $file->companies()->detach();

        return $file->delete();
    }


    public function destroyBenefitsForCompany(Company $company): void
    {
        $company->benefits?->each(fn (Benefit $benefit) => $benefit->delete());
    }

    public function destroyCompany(Company $company): void
    {
        $company->delete();
    }

    private function putDataToCompanyCollection(): void
    {
        $this->companyCollection->put('user_id', Auth::user()->id);
        if ($this->companyCollection->get('name')) {
            $this->companyCollection->put('slug', Str::slug($this->companyCollection->get('name')));
        }
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

    private function updateOrCreateSocialForCompany(array $socialDataToFind, array $socialData): void
    {
        Social::updateOrCreate($socialDataToFind, $socialData);
    }

    private function createLocationForCompany(): Location
    {
        return Location::create($this->companyCollection->toArray());
    }

    private function updateLocationForCompany(): void
    {
        $this->company->location?->update($this->companyCollection->toArray());
    }

    private function deleteSocialForCompany(Social $social): bool|null
    {
        return $social->delete();
    }

    private function storeMultipleImagesForCompany(string $collection, array $images): void
    {
        foreach ($images as $image) {
            $this->storeImageForCompany($collection, $image);
        }
    }

    private function storeImageForCompany(string $collection, UploadedFile $image): void
    {
        $image->store($collection, config('app.uploads.disk'));

        $file = $this->createImage($collection, $image);

        $this->fileIds[] = $file->id;
    }

    private function createImage(string $collection, UploadedFile $image): File
    {
        $path = $collection . '/' . $image->hashName();

        return File::create([
            'name' => $image->hashName(),
            'disk' => config('app.uploads.disk'),
            'path' => $path,
            'mime_type' => $image->getClientMimeType(),
            'collection' => $collection,
        ]);
    }

    private function attachFilesToCompany(Company $company): void
    {
        $company->files()->attach($this->fileIds);
    }
}
