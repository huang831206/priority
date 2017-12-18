<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BoardResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('board_resources')->truncate();

        // lists
        DB::table('board_resources')->insert([
            [
                'board_id' => 1,
                'resource_type' => 'list',
                'resource_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'board_id' => 1,
                'resource_type' => 'list',
                'resource_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

        // tags
        DB::table('board_resources')->insert([
            [
                'board_id' => 1,
                'resource_type' => 'tag',
                'resource_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'board_id' => 1,
                'resource_type' => 'tag',
                'resource_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

        // user
        DB::table('board_resources')->insert([
            [
                'board_id' => 1,
                'resource_type' => 'user',
                'resource_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'board_id' => 1,
                'resource_type' => 'user',
                'resource_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
