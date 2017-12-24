<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('cards')->truncate();

        DB::table('cards')->insert([
            [
                'card_hash' => 'c01',
                'name' => 'card no.1',
                'in_list' => 'l01',
                'pos' => 0,
                'content' => 'content of card',
                'point' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'card_hash' => 'c02',
                'name' => 'card no.2',
                'in_list' => 'l01',
                'pos' => 1,
                'content' => 'content of card',
                'point' => 5,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
