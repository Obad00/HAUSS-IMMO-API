<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = \App\Models\Admin::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Associe un utilisateur au rôle d'administrateur
        ];
    }
}
