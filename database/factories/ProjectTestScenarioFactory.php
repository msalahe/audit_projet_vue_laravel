<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectTestScenario>
 */
class ProjectTestScenarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'test_scenario' => $this->faker->text(),
            'test_status' => $this->faker->randomElement(['passed', 'failed']),
        ];
    }
}
