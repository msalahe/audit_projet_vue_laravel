<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocialLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* foreach (['Github','Telegram','LinkedIn','Website'] as $socialLink) {
            DB::table('social_links')->updateOrInsert(
                [
                    'rs_name' => $socialLink,
                ],
                [
                    'user_id' => '',
                    'rs_link' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        } */
    }
}
