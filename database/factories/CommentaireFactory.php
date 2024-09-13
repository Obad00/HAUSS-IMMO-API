<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    protected $model = \App\Models\Commentaire::class;

    public function definition()
    {
        return [
            'nomComplet' => $this->faker->name,
            'note' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph,
            'user_id' => \App\Models\User::factory(), // Associe un utilisateur au commentaire
        ];
    }
}
