<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\SocialNetwork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Social>
 */
class SocialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => random_int(1, Company::all()->count()),
            'social_network_id' => random_int(1, SocialNetwork::all()->count()),
            'url' => $this->faker->url,
        ];
    }
}
