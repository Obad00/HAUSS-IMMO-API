<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Support;

class SupportSeeder extends Seeder
{
    public function run()
    {
        Support::factory()->count(5)->create(); // Crée 5 demandes de support fictives
    }
}
