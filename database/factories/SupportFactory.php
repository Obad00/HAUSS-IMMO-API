<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupportFactory extends Factory
{
    protected $model = \App\Models\Support::class;

    public function definition()
    {
        return [
            'typeDemande' => $this->faker->randomElement(['technique', 'administratif', 'autre']),
            'user_id' => \App\Models\User::factory(), // Associe un utilisateur à la demande de support
        ];
    }
}
