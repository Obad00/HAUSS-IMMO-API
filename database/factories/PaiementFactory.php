<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    protected $model = \App\Models\Paiement::class;

    public function definition()
    {
        return [
            'montant' => $this->faker->numberBetween(10000, 50000),
            'type' => $this->faker->randomElement(['carte', 'paypal', 'virement', 'autre']),
            'commission' => $this->faker->numberBetween(500, 5000),
            'reservation_id' => \App\Models\Reservation::factory(),
        ];
    }
}
