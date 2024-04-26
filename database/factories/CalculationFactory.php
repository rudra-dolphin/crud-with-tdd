<?php

namespace Database\Factories;

use App\Models\Calculation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calculation>
 */
class CalculationFactory extends Factory
{
    protected $model = Calculation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->numberBetween(1, 1000); // Random amount
        $percentage = $this->faker->numberBetween(1, 100); // Random percentage

        return [
            'amount' => $amount,
            'percentage' => $percentage,
            'result' => ($amount * $percentage) / 100, // Calculate result
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
