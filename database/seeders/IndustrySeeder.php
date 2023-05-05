<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Industry::create(['name' => 'IT']);
        Industry::create(['name' => 'Finanse/Ekonomia']);
        Industry::create(['name' => 'Transport']);
        Industry::create(['name' => 'Budownictwo']);
        Industry::create(['name' => 'Fryzjerstwo/Kosmetyka']);
        Industry::create(['name' => 'Administracja biurowa']);
        Industry::create(['name' => 'Turystyka']);
        Industry::create(['name' => 'Handel']);
        Industry::create(['name' => 'Energetyka']);
        Industry::create(['name' => 'Mechanika']);
        Industry::create(['name' => 'Inżynieria']);
        Industry::create(['name' => 'Edukacja']);
        Industry::create(['name' => 'Zdrowie']);
        Industry::create(['name' => 'Gastronomia']);
        Industry::create(['name' => 'Rolnictwo']);
        Industry::create(['name' => 'Badania i rozwój']);
        Industry::create(['name' => 'Sprzątanie']);
        Industry::create(['name' => 'Magazyn']);
        Industry::create(['name' => 'Produkcja']);
        Industry::create(['name' => 'Doradztwo/Call center']);
        Industry::create(['name' => 'Prawo']);
        Industry::create(['name' => 'Marketing']);
        Industry::create(['name' => 'Atystyczne']);
        Industry::create(['name' => 'Ochrona środowiska']);
        Industry::create(['name' => 'Nieruchomości']);
    }
}
