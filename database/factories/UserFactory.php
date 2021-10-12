<?php

namespace Database\Factories;

use App\Model\Song;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Song::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'year' => $this->faker->year(4),
            'artist' => $this->faker->name,
            'gendre' => $this->faker->company,
            'duration' => $this->faker->time,
        ];
    }
}
