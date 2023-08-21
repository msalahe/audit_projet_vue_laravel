<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\AuditProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectIssue>
 */
class ProjectIssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
       $auditProject =  AuditProject::factory()->create();
         return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'attack_scenario' => fake()->paragraph(),
            'recommendation' => fake()->paragraph(),
            'updates' => fake()->paragraph(),
            'likelihood' => fake()->randomElement(['1', '2', '3']),
            'impact' => fake()->randomElement(['-1','0', '1', '2', '3']),
            'status' => fake()->randomElement(['Not Fixed', 'Fixed', 'Mitigated', 'Acknowledged', 'Partially Fixed']),
            'state' => fake()->randomElement(['Draft', 'Approved', 'Pending', 'Duplicated', 'Not Approved']),
            'user_id' => $auditProject->user_id,
            'project_id' =>$auditProject->id
        ];
    }
}
