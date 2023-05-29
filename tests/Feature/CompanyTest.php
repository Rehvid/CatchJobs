<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Enums\Employees;
use App\Enums\Status;
use App\Models\Benefit;
use App\Models\File;
use App\Models\Location;
use App\Models\Social;
use App\Models\SocialNetwork;
use App\Models\User;
use Database\Factories\ImageFileFactory;
use Database\Seeders\BenefitSeeder;
use Database\Seeders\IndustrySeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use App\Models\Company;
use Database\Seeders\SocialNetworkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCompanyIndexPageIsDisplayed(): void
    {
        $response = $this->get(route('companies.index'));
        $response->assertOk();
    }

    public function testCompanyShowPageIsDisplayed(): void
    {
        $this->seed(IndustrySeeder::class);
        $this->seed(BenefitSeeder::class);

        User::factory()->create();
        $company = Company::factory()->create();

        $response = $this->get(route('companies.show', $company));
        $response->assertOk();
    }

    public function testCompanyListPageIsDisplayedForEmployer(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);

        $response = $this
            ->actingAs($user)
            ->get(route('companies.list', $user));

        $response->assertOk();
    }

    public function testCompanyListPageIsNotDisplayedForUserWithoutPermissionToDisplay(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::USER->value);
        $user->assignRole($employerRole);

        $response = $this
            ->actingAs($user)
            ->get(route('companies.list'));

        $response->assertForbidden();
    }

    public function testCompanyAdminListPageIsDisplayedForAdmin(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $adminRole = Role::findByName(UserRole::ADMIN->value);
        $user->assignRole($adminRole);

        $response = $this
            ->actingAs($user)
            ->get(route('companies.list', $user));

        $response->assertOk();
    }

    public function testCompanyAdminListPageIsNotDisplayedForUserWithoutPermissionToDisplay(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::USER->value);
        $user->assignRole($employerRole);

        $response = $this
            ->actingAs($user)
            ->get(route('companies.list'));

        $response->assertForbidden();
    }

    public function testCompanyCreatePageIsDisplayedForUserWithPermissionToDisplay(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);

        $response = $this
            ->actingAs($user)
            ->get(route('companies.create'));

        $response->assertOk();
    }

    public function testCompanyCreatePageIsNotDisplayedForUserWithoutPermissionToDisplay(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $userRole = Role::findByName(UserRole::USER->value);
        $user->assignRole($userRole);

        $response = $this
            ->actingAs($user)
            ->get(route('companies.create'));

        $response->assertForbidden();
    }

    public function testCompanyCreate(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);

        $response = $this
            ->actingAs($user)
            ->post(route('companies.store'), [
                'name' => $this->faker->word,
                'vat_number' => $this->faker->unique->numerify('##########'),
                'description' => $this->faker->sentence(12),
                'employees' => $this->faker->randomElement(Employees::cases())->value,
                'foundation_year' => $this->faker->year,
                'benefits' => '[{"value":"Aktywność sportowa"},{"value":"Dofinansowanie nauki jezyków"}]',
                'industry' => $this->faker->sentence
            ]);


        $response->assertRedirect(route('companies.list'));
    }

    public function testCompanyCreateWithoutRequiredFields(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);

        $response = $this
            ->actingAs($user)
            ->post(route('companies.store'), [
                'name' => '',
                'vat_number' => '',
                'description' => $this->faker->sentence(12),
                'employees' => $this->faker->randomElement(Employees::cases())->value,
                'foundation_year' => $this->faker->year,
                'benefits' => '[{"value":"Aktywność sportowa"},{"value":"Dofinansowanie nauki jezyków"}]',
                'industry' => $this->faker->sentence
            ]);


        $response->assertSessionHasErrors(['name', 'vat_number']);
    }

    public function testCompanyCreateWithDuplicatedUniqueFields(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(IndustrySeeder::class);
        $this->seed(BenefitSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);

        $company = Company::factory()->create([
            'name' => 'TestCompany',
            'vat_number' => '0000000000'
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('companies.store'), [
                'name' => 'TestCompany',
                'vat_number' => '0000000000',
                'description' => $this->faker->sentence(12),
                'employees' => $this->faker->randomElement(Employees::cases())->value,
                'foundation_year' => $this->faker->year,
                'benefits' => '[{"value":"Aktywność sportowa"},{"value":"Dofinansowanie nauki jezyków"}]',
                'industry' => $this->faker->sentence
            ]);


        $this->assertDatabaseHas('companies', [
            'name' => $company->name,
            'vat_number' => $company->vat_number
        ]);

        $response->assertSessionHasErrors(['name', 'vat_number']);
    }

    public function testCompanyCreateWithWrongSyntaxInBenefitField(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);

        $user->assignRole($employerRole);


        $response = $this
            ->actingAs($user)
            ->post(route('companies.store'), [
                'name' => $this->faker->word,
                'vat_number' => $this->faker->unique->numerify('##########'),
                'description' => $this->faker->sentence(12),
                'employees' => $this->faker->randomNumber(4),
                'foundation_year' => $this->faker->randomElement(Employees::cases())->value,
                'benefits' => '{"value":"Aktywność sportowa"},"value":"Dofinansowanie nauki jezyków"}]',
                'industry' => $this->faker->sentence
            ]);


        $response->assertSessionHasErrors(['benefits']);
    }


    public function testCompanyCreateWithLocationSocialFileAndAssignedThemToCompany(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(SocialNetworkSeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);

        $companyName = $this->faker->unique->sentence();
        $locationEmail = $this->faker->unique->email;
        $imageLogo = UploadedFile::fake()->image('logo.jpg', 100, 100);
        $imageCover = UploadedFile::fake()->image('cover.png', 1200, 400);
        $imageGallery = UploadedFile::fake()->image('gallery.webp', 540, 360);

        $response = $this
            ->actingAs($user)
            ->post(route('companies.store'), [
                'name' => $companyName,
                'vat_number' => $this->faker->unique->numerify('##########'),
                'description' => $this->faker->sentence(12),
                'employees' => $this->faker->randomElement(Employees::cases())->value,
                'foundation_year' => $this->faker->year,
                'benefits' => '[{"value":"Aktywność sportowa"},{"value":"Dofinansowanie nauki jezyków"}]',
                'location_id' => 0,
                'alias' => $this->faker->word,
                'postcode' => $this->faker->postcode,
                'province' => Str::ucfirst($this->faker->state),
                'city' => $this->faker->city,
                'street' => $this->faker->streetName,
                'phone' => $this->faker->numerify('##########'),
                'email' => $locationEmail,
                'industry' => $this->faker->sentence,
                'facebook' => $this->faker->url,
                'instagram' => $this->faker->url,
                'linkedin' => $this->faker->url,
                'twitter' => $this->faker->url,
                'website' => $this->faker->url,
                'image_logo' => $imageLogo,
                'image_cover' => $imageCover,
                'image_gallery' => [
                    $imageGallery,
                ]
            ]);

        $this->assertDatabaseHas('companies', [
            'name' => $companyName
        ]);
        $this->assertDatabaseHas('locations', [
            'email' => $locationEmail
        ]);
        $this->assertDatabaseCount('socials', 5);
        $this->assertDatabaseCount('files', 3);

        Storage::disk(config('app.uploads.disk'))->assertExists('logo/' . $imageLogo->hashName());
        Storage::disk(config('app.uploads.disk'))->assertExists('cover/' . $imageCover->hashName());
        Storage::disk(config('app.uploads.disk'))->assertExists('gallery/' . $imageGallery->hashName());

        $response->assertRedirect(route('companies.list'));
    }


    public function testCompanyUpdate(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(SocialNetworkSeeder::class);
        $this->seed(IndustrySeeder::class);
        $this->seed(BenefitSeeder::class);

        $user = User::factory()->create();
        $user->assignRole(Role::findByName(UserRole::EMPLOYER->value));
        $company = Company::factory(state:['user_id' => $user->id])->create();

        SocialNetwork::all()->each(function ($socialNetwork) use ($company) {
            Social::factory(state: [
                'company_id' => $company->id,
                'social_network_id' => $socialNetwork->id
            ])->create();
        });


        $companyName = $this->faker->unique->word;
        $vatNumber = $this->faker->unique->numerify('##########');

        $response = $this
            ->actingAs($user)
            ->patch(
                route('companies.update', $company->slug), [
                'name' => $companyName,
                'vat_number' => $vatNumber,
                'location_id' => null,
                'industry' => $this->faker->word,
                'facebook' => $this->faker->url,
                'instagram' => $this->faker->url,
            ]);

        $this->assertDatabaseCount('socials', 2);
        $this->assertDatabaseHas('companies', [
            'location_id' => null,
            'name' => $companyName,
            'vat_number' => $vatNumber
        ]);

        $response->assertRedirect(route('companies.list'));
    }

    public function testCompanyChangeLocationAssociatedToCompany(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(IndustrySeeder::class);


        $user = User::factory()->create();
        $user->assignRole(Role::findByName(UserRole::EMPLOYER->value));
        $location = Location::factory(2, ['user_id' => $user->id])->create();
        $company = Company::factory(state:[
            'user_id' => $user->id,
            'location_id' => $location->first()->id
        ])->create();

        $alias = $this->faker->unique->word;
        $postcode = $this->faker->unique->postcode;
        $province = Str::ucfirst($this->faker->unique->state);
        $city = $this->faker->unique->city;
        $street = $this->faker->unique->streetName;

        $response = $this
            ->actingAs($user)
            ->patch(
                route('companies.update', $company), [
                'name' => $company->name,
                'vat_number' => $company->vat_number,
                'location_id' => $location->last()->id,
                'alias' => $alias,
                'postcode' => $postcode,
                'province' => $province,
                'city' => $city,
                'street' => $street,
            ]);

        $this->assertDatabaseHas('companies', [
            'location_id' => $location->last()->id
        ]);

        $this->assertDatabaseHas('locations', [
            'id' => $location->last()->id,
            'alias' => $alias,
            'postcode' => $postcode,
            'province' => $province,
            'city' => $city,
            'street' => $street
        ]);

        $this->assertNotEquals($location->last()->alias, $alias);
        $this->assertNotEquals($location->last()->postcode, $postcode);
        $this->assertNotEquals($location->last()->province, $province);
        $this->assertNotEquals($location->last()->city, $city);
        $this->assertNotEquals($location->last()->street, $street);

        $response->assertRedirect(route('companies.list'));
    }


    public function testCompanyDestroyLogoAssociatedToCompany(): void
    {

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(IndustrySeeder::class);

        $user = User::factory()->create();
        $employerRole = Role::findByName(UserRole::EMPLOYER->value);
        $user->assignRole($employerRole);
        $company = Company::factory(state:[
            'user_id' => $user->id,
        ])->create();
        $imageLogo = UploadedFile::fake()->image('logo.jpg', 100, 100);

        $this->actingAs($user)->patch(route('companies.update', $company), [
            'name' => $this->faker->unique->sentence(),
            'vat_number' => $this->faker->unique->numerify('##########'),
            'image_logo' => $imageLogo,
        ]);

        Storage::disk(config('app.uploads.disk'))->assertExists('logo/' . $imageLogo->hashName());

        $idFile = File::all()->first()->id;

        $response = $this
            ->actingAs($user)
            ->delete(route('companies.destroy_image'), [
                'id' => $idFile,
                'company_id' => $company->id
            ]);

        Storage::disk(config('app.uploads.disk'))->assertMissing('logo/' . $imageLogo->hashName());

        $response->assertJson(['status' => true]);
    }

    public function testCompanyDestroyWithAllAssociatedData(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(SocialNetworkSeeder::class);
        $this->seed(IndustrySeeder::class);
        $this->seed(BenefitSeeder::class);

        ImageFileFactory::new()->count(3)->create();
        $user = User::factory()->create();
        $user->assignRole(Role::findByName(UserRole::EMPLOYER->value));
        $location = Location::factory(state:['user_id' => $user->id])->create();
        $company = Company::factory(state:[
            'user_id' => $user->id,
            'location_id' => $location->id
        ])->create();

        SocialNetwork::all()->each(function ($socialNetwork) use ($company) {
            Social::factory(state: [
                'company_id' => $company->id,
                'social_network_id' => $socialNetwork->id
            ])->create();
        });

        Benefit::all()->each(fn ($benefit) => $company->benefits()->attach($benefit->id));
        $files = File::all()->each(fn ($file) => $company->files()->attach($file->id));

        $filesPath = $files->transform(function ($file) {
            return $file->path;
        });

        $response = $this
            ->actingAs($user)
            ->delete(route('companies.destroy', $company));

        $filesPath->each(fn ($filePath) => Storage::disk(config('app.uploads.disk'))->assertMissing($filePath));

        $this->assertDatabaseEmpty('companies');
        $this->assertDatabaseEmpty('files');
        $this->assertDatabaseEmpty('socials');
        $this->assertDatabaseEmpty('company_file');
        $this->assertDatabaseEmpty('benefit_company');

        $response->assertRedirect(route('companies.list'));
    }

    public function testCompanyUpdateStatus(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
        $this->seed(SocialNetworkSeeder::class);
        $this->seed(IndustrySeeder::class);
        $this->seed(BenefitSeeder::class);

        $user = User::factory()->create();
        $user->assignRole(Role::findByName(UserRole::ADMIN->value));
        $company = Company::factory()->create();
        $status = $this->faker->randomElement(Status::cases());

        $response = $this
            ->actingAs($user)
            ->patch(route('admin.companies.update_status', $company), [
                'status' => $status->value,
                'status_message' => $status === Status::REJECT ? $this->faker->sentence : null
            ]);

        $response->assertRedirect(route('admin.companies.list'));
    }

}
