<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = \App\Models\Reservation::class;

    public function definition()
    {
        return [
            'statut' => $this->faker->randomElement(['acceptee', 'déclinee']),
            'locataire_id' => \App\Models\Locataire::factory(),
            'logement_id' => \App\Models\Logement::factory(),
        ];
    }
}
