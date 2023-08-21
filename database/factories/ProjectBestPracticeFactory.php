<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\AffectedFile;
use App\Models\AuditProject;
use App\Models\ProjectBestPractice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectBestPractice>
 */
class ProjectBestPracticeFactory extends Factory
{
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (ProjectBestPractice $projectBestPractice) {
            //
        })->afterCreating(function (ProjectBestPractice $projectBestPractice) {
           /*  AffectedFile::factory()
                ->state(new Sequence(
                    fn ($sequence) => [
                        'root_id' =>$projectBestPractice->id,
                        'type' => 2
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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'code' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'project_id' => AuditProject::factory(),
            'user_id' =>  User::factory(),
            'status' => $this->faker->randomElement(['Not Fixed', 'Fixed', 'Mitigated', 'Acknowledged', 'Partially Fixed']),
            'state' => $this->faker->randomElement(['Draft', 'Approved', 'Pending', 'Duplicated', 'Not Approved']),

        ];
    }
}
