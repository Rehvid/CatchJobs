<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, User::all()->count()),
            'alias' => $this->faker->word,
            'postcode' => $this->faker->postcode,
            'province' => Str::ucfirst($this->faker->state),
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'phone' => $this->faker->unique->numerify('##########'),
            'email' => $this->faker->unique->email,
        ];
    }
}
