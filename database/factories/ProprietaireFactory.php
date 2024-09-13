<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProprietaireFactory extends Factory
{
    protected $model = \App\Models\Proprietaire::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Associe un utilisateur au propriétaire
        ];
    }
}
