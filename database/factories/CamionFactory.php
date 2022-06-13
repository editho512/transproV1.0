<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CamionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
            'annee' => $this->faker->year(),
            'model' => $this->faker->text(20),
            'marque' => $this->faker->text(20),
            'numero_chassis' => rand(15, 15),
        ];
    }
}
