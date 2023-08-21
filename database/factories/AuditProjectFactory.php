<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Str;
use App\Models\AuditProject;
use App\Models\ProjectBestPractice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuditProject>
 */
class AuditProjectFactory extends Factory
{
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (AuditProject $auditProject) {
            //
        })->afterCreating(function (AuditProject $auditProject) {
            /* ProjectBestPractice::factory()
                ->count(2)
                ->state(new Sequence(
                    fn ($sequence) => [
                        'project_id' =>$auditProject->id,
                        'user_id' =>$auditProject->user_id
                    ],
            ))
            ->create(); */

        });
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => Str::orderedUuid(),
            'name' => fake()->word(),
            'start_date' => fake()->date(),
            'finish_date' => fake()->date(),
            'jira_id' => fake()->uuid(),
            'slack_channel' => fake()->word(),
            'client' => fake()->name(),
            'description' => fake()->paragraph(),
            'website' => fake()->url(),
            'audit_type' => fake()->randomElement(['Solidity smart contracts', 'Rust Programs', 'PyTeal Smart Contracts', 'Reach Smart Contracts', 'DApp Security']),
            'audit_method' => fake()->randomElement(['WhiteBox', 'BlackBox']),
            'is_published' => fake()->boolean(),
            'summary' => fake()->sentence(),
            'disclaimer' => fake()->paragraph(),
            'findings' => fake()->paragraph(),
            'conclusion' => fake()->paragraph(),
            'type' => fake()->randomElement(['Private', 'Public']),
            'status_id' => Status::firstOrCreate([
                'name' => fake()->randomElement(['Not Fixed', 'Fixed', 'Mitigated', 'Acknowledged', 'Partially Fixed'])
            ])->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
