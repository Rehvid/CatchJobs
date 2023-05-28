<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Benefit;
use App\Models\Company;
use App\Models\File;
use App\Models\Location;
use App\Models\Social;
use App\Models\SocialNetwork;
use App\Models\User;
use Database\Factories\SocialFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(IndustrySeeder::class);
        $this->call(BenefitSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(SocialNetworkSeeder::class);

        User::factory(20)->create();
        Location::factory(50)->create();
        File::factory(50)->create();

        $files = File::all();
        $benefits = Benefit::all();
        Company::factory(20)->create()
            ->each(function ($company) use ($files, $benefits) {
                $company->files()->attach($files->random(5));
                $company->benefits()->attach($benefits->random(random_int(2,8)));
                for ($i = 1; $i <= 5; $i ++) {
                    Social::factory(state: [
                        'company_id' => $company->id,
                        'social_network_id' => $i
                    ])->create();
                }
            });
    }
}
