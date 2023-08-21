<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\ProjectBestPractice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AffectedFile>
 */
class AffectedFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = $this->faker->randomElement([1, 2]);
        $rootId = ($type == 2)
            ? ProjectBestPractice::factory()->create()->id
            : Issue::factory()->create()->id;

            return [
                'root_id' => $rootId,
                'type' => $type,
                'order' => $this->faker->randomNumber(),
                'file_name' => $this->faker->word . '.sol',
                'start_line' => $this->faker->randomNumber(),
                'code' => $this->faker->text,
        ];
    }
}
