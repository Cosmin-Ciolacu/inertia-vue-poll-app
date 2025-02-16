<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PollOption>
 */
class PollOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PollOption::class;

    public function definition(): array
    {
        return [
            'poll_id' => Poll::all()->random()->id,
            'option' => $this->faker->sentence(),
            'votes' => $this->faker->numberBetween(0, 1000)
        ];
    }
}
