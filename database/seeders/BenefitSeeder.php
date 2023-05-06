<?php

namespace Database\Seeders;

use App\Models\Benefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    public function run(): void
    {
        Benefit::create(['name' => 'Prywatna opieka medyczna']);
        Benefit::create(['name' => 'Elastyczny czas pracy']);
        Benefit::create(['name' => 'Dodatkowy urlop']);
        Benefit::create(['name' => 'Dofinansowanie nauki jezyków']);
        Benefit::create(['name' => 'Dofinansowanie zajęc sportowych']);
        Benefit::create(['name' => 'Możliwość pracy zdalnej']);
        Benefit::create(['name' => 'Firmowa biblioteka']);
        Benefit::create(['name' => 'Siłownia w biurze']);
        Benefit::create(['name' => 'Strefa relaksu']);
        Benefit::create(['name' => 'Kawa/herbata']);
        Benefit::create(['name' => 'Owoce']);
        Benefit::create(['name' => 'Spotkania integracyjne']);
        Benefit::create(['name' => 'Paczki świąteczne']);
        Benefit::create(['name' => 'Przyjazne miejsce pracy']);
        Benefit::create(['name' => 'Parking dla pracowników']);
        Benefit::create(['name' => 'Aktywność sportowa']);
    }
}
