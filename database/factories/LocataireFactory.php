<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocataireFactory extends Factory
{
    protected $model = \App\Models\Locataire::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Associe un utilisateur au locataire
        ];
    }
}
