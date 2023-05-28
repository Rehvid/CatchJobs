<?php

namespace Database\Seeders;

use App\Models\SocialNetwork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialNetwork::create(['name' => 'facebook']);
        SocialNetwork::create(['name' => 'linkedin']);
        SocialNetwork::create(['name' => 'instagram']);
        SocialNetwork::create(['name' => 'website']);
        SocialNetwork::create(['name' => 'twitter']);
    }
}
