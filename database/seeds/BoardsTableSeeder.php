<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('boards')->truncate();

        DB::table('boards')->insert([
            [
                'board_hash' => 'b01',
                'name' => 'board no.1',
                'user_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'board_hash' => 'b02',
                'name' => 'board no.2',
                'user_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
