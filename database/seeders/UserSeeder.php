<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed roles
        $this->call([
            RoleSeeder::class,
        ]);

        User::factory()
            ->count(10)
            ->state(new Sequence(
                fn ($sequence) => ['role_id' => Role::where('name','!=','Lead Auditor')->get()->random()->id],
            ))
            ->create();
    }
}
