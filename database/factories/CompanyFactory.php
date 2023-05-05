<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();
        return [
            'user_id' => random_int(1, User::all()->count()),
            'location_id' => null,
            'industry_id' => null,
            'name' => $name,
            'slug' => Str::slug($name),
            'vat_number' => fake()->unique()->numerify('##########'),
            'status' => random_int(0, 2),
            'description' => fake()->unique()->paragraph(),
            'employees' => fake()->randomNumber(),
            'foundation_year' => fake()->year()
        ];
    }
}
