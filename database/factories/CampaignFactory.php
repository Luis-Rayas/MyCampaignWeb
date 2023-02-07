<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company() ,
            'party' => $this->faker->companySuffix() ,
            'description' => $this->faker->text(100),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime()
        ];
    }
}
