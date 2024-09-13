<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run()
    {
        Categorie::factory()->count(5)->create(); // Crée 5 catégories fictives
    }
}
