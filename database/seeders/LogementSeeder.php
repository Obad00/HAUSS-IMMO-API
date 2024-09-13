<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logement;

class LogementSeeder extends Seeder
{
    public function run()
    {
        Logement::factory()->count(10)->create(); // Crée 10 logements fictifs
    }
}
