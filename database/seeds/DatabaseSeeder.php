<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->command->info('User table seeded!');
        $this->call(BoardsTableSeeder::class);
        $this->command->info('boards table seeded!');
        $this->call(ListsTableSeeder::class);
        $this->command->info('lists table seeded!');
        $this->call(CardsTableSeeder::class);
        $this->command->info('cards table seeded!');
        $this->call(TagsTableSeeder::class);
        $this->command->info('tags table seeded!');
        $this->call(BoardResourcesTableSeeder::class);
        $this->command->info('board_resources table seeded!');
        $this->call(ListCardsTableSeeder::class);
        $this->command->info('list_cards table seeded!');
        $this->call(CardTagsTableSeeder::class);
        $this->command->info('card_tags table seeded!');
    }
}
