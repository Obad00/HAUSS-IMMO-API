<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = \App\Models\Notification::class;

    public function definition()
    {
        return [
            'sujet' => $this->faker->word,
            'message' => $this->faker->sentence,
            'user_id' => \App\Models\User::factory(), // Associe un utilisateur à la notification
        ];
    }
}
