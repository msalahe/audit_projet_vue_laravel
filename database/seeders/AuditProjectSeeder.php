<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Role;
use App\Models\User;
use App\Models\Skill;
use App\Models\ProjectQa;
use App\Models\Blockchain;
use App\Models\ProjectTest;
use App\Models\AffectedFile;
use App\Models\AuditProject;
use App\Models\ProjectIssue;
use App\Models\ProjectScope;
use Illuminate\Database\Seeder;
use App\Models\ProjectBestPractice;
use App\Models\ProjectTestScenario;
use App\Models\ProjectTotalCoverage;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuditProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            SkillSeeder::class,
        ]);
        $leadAuditorRole = Role::where('name', 'Lead Auditor')->first();

        $users = User::whereDoesntHave('role', function ($q) {
            $q->where('name', 'Admin');
        })
            ->take(10)
            ->get();

        $tags = Tag::all();

        $skills = Skill::all();

        $blockchains = Blockchain::all();

        AuditProject::factory(10)
            ->has(ProjectBestPractice::factory()
                ->has(AffectedFile::factory()
                    ->state(
                        new Sequence(
                            fn ($sequence) => [
                                'type' => 2,
                            ]
                        )
                    )
                    ->count(3), 'affectedFiles')
                ->count(3), 'bestPractices')
                ->has(ProjectScope::factory()
                ->count(3), 'scopes')
                ->has(ProjectQa::factory()
                ->count(3), 'qas')
                ->has(ProjectIssue::factory()
                ->count(3), 'issues')
                ->has(ProjectTest::factory()
                ->count(1), 'tests')
                ->has(ProjectTestScenario::factory()
                ->count(10), 'testScenarios')
                ->has(ProjectTotalCoverage::factory()
                ->count(3), 'totalCoverages')
            ->create()
            ->each(function ($auditProject) use ($users, $leadAuditorRole, $tags, $skills, $blockchains) {
                $leadAuditor = $users->first();

                $randomUsers = $users->where('id', '<>', $leadAuditor->id)->random(rand(0, 4));
                $randomUsers->push($leadAuditor);
                $randomUsers->each(function ($user) use ($auditProject, $leadAuditorRole) {
                    $roleId = $user->id === $leadAuditorRole->id ? $leadAuditorRole->id : Role::where('name', '!=', 'Admin')->inRandomOrder()->first()->id;

                    // Add users(): BelongsToMany
                    $auditProject->users()->attach($user->id, ['role_id' => $roleId]);
                });

                // Add tags(): BelongsToMany
                $auditProject->tags()->attach($tags->random(rand(1, 3))->pluck('id'));

                // Add languages(): BelongsToMany
                $auditProject->languages()->attach($skills->random(rand(1, 3))->pluck('id'));

                // Add blockchains(): BelongsToMany
//                $auditProject->blockchains()->attach($blockchains->random(rand(1, 3))->pluck('id'));
            });
    }
}
