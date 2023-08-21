<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectScope>
 */
class ProjectScopeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'link' => $this->faker->url,
            'value' => $this->faker->randomFloat(2, 100, 1000),
            'type' => $this->faker->randomElement(['Contract', 'Github', 'GitLab', 'Bitbucket']),
            'status_id' => $this->faker->randomElement(Status::pluck('id')->toArray()),
        ];
    }
}
