<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            LocataireSeeder::class,
            ProprietaireSeeder::class,
            LogementSeeder::class,
            CategorieSeeder::class,
            ReservationSeeder::class,
            NotificationSeeder::class,
            SupportSeeder::class,
            CommentaireSeeder::class,
            PaiementSeeder::class,
            AdminSeeder::class, // Ajoutez le seeder pour les administrateurs
        ]);
    }
}
