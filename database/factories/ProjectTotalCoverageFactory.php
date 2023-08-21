<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectTotalCoverage>
 */
class ProjectTotalCoverageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'statements' => $this->faker->randomFloat(2, 0, 100),
            'branches' => $this->faker->randomFloat(2, 0, 100),
            'functions' => $this->faker->randomFloat(2, 0, 100),
            'lines' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
