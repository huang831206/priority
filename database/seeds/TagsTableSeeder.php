<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('tags')->truncate();

        DB::table('tags')->insert([
            [
                'tag_id' => 't01',
                'name' => 'tag 1',
                'color' => 'red',
                'in_board' => 'b01',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'tag_id' => 't02',
                'name' => 'tag 2',
                'color' => 'blue',
                'in_board' => 'b01',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
