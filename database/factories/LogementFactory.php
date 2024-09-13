<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LogementFactory extends Factory
{
    protected $model = \App\Models\Logement::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->word,
            'adresse' => $this->faker->address,
            'type' => $this->faker->randomElement(['appartement', 'maison']),
            'image' => $this->faker->imageUrl(),
            'ville' => $this->faker->city,
            'region' => $this->faker->state,
            'quartier' => $this->faker->word,
            'nombreChambre' => $this->faker->numberBetween(1, 5),
            'nombreToilette' => $this->faker->numberBetween(1, 3),
            'nombreEtage' => $this->faker->numberBetween(1, 3),
            'surface' => $this->faker->numberBetween(30, 150),
            'description' => $this->faker->paragraph,
            'prix' => $this->faker->numberBetween(10000, 50000),
            'proprietaire_id' => \App\Models\Proprietaire::factory(), // Associe un propriétaire au logement
        ];
    }
}
