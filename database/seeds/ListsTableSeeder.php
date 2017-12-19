<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('lists')->truncate();

        DB::table('lists')->insert([
            [
                'list_hash' => 'l01',
                'name' => 'list no.1',
                'in_board' => 'b01',
                'pos' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'list_hash' => 'l02',
                'name' => 'list no.2',
                'in_board' => 'b01',
                'pos' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
