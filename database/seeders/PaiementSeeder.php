<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paiement;

class PaiementSeeder extends Seeder
{
    public function run()
    {
        Paiement::factory()->count(5)->create(); // Crée 5 paiements fictifs
    }
}
