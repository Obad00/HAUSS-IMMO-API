<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commentaire;

class CommentaireSeeder extends Seeder
{
    public function run()
    {
        Commentaire::factory()->count(10)->create(); // Crée 10 commentaires fictifs
    }
}
