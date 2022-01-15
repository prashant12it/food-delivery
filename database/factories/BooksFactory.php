<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BooksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(),
            'description'=>$this->faker->paragraph(3),
            'author' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'price' => $this->faker->numberBetween(100,1000),
        ];
    }
}
