<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->insert([
            [
                'owner_id' => 1,
                'title' => 'Test Topic1',
                'category_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'owner_id' => 1,
                'title' => 'Test Topic2',
                'category_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'owner_id' => 1,
                'title' => 'Test Topic3',
                'category_id' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'owner_id' => 2,
                'title' => 'Test Topic4',
                'category_id' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'owner_id' => 2,
                'title' => 'Test Topic5',
                'category_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
