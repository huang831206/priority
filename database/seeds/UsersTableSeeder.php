<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        App\User::create([
            'email' => 'huang831206@gmail.com',
            'name'=>'admin',
            'password'=>Hash::make('123456'),
            'priority' => '[]',
        ]);

        App\User::create([
            'email' => 't@gmail.com',
            'name'=>'tester',
            'password'=>Hash::make('123456'),
            'priority' => '[]',
        ]);
    }
}
