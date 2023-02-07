<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'fathers_lastname' => $this->faker->lastname,
            'mothers_lastname' => $this->faker->lastname,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '1234567890',
            'section_id' => Section::factory(),
            'sympathizer_id' => Sympathizer::factory(),
        ];
    }
}
