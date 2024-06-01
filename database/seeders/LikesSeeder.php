<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            [
                'user_id' => 1,
                'topic_id' => 1,
            ],
            [
                'user_id' => 2,
                'topic_id' => 1,
            ],
            [
                'user_id' => 3,
                'topic_id' => 1,
            ],
            [
                'user_id' => 1,
                'topic_id' => 2,
            ],
            [
                'user_id' => 2,
                'topic_id' => 2,
            ],
            [
                'user_id' => 1,
                'topic_id' => 3,
            ],
        ]);
    }
}
