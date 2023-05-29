<?php

namespace Database\Factories;

use App\Enums\Employees;
use App\Enums\Status;
use App\Models\Industry;
use App\Models\Location;
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
        $name = $this->faker->unique->word;
        $userId = random_int(1, User::all()->count());
        $status = $this->faker->randomElement(Status::cases());

        return [
            'user_id' => $userId,
            'location_id' => Location::byUserId($userId)->first()->id ?? null,
            'industry_id' => random_int(1, Industry::all()->count()),
            'name' => $name,
            'slug' => Str::slug($name),
            'vat_number' => $this->faker->unique->numerify('##########'),
            'status' => $status->value,
            'status_message' => $status === Status::REJECT
                ? $this->faker->text
                : null,
            'description' => $this->faker->paragraph(6),
            'employees' => $this->faker->randomElement(Employees::cases())->value,
            'foundation_year' => $this->faker->year
        ];
    }
}
