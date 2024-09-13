<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locataire;

class LocataireSeeder extends Seeder
{
    public function run()
    {
        Locataire::factory()->count(5)->create(); // Crée 5 locataires fictifs
    }
}
