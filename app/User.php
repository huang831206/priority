<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'priority'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeCards($query)
    {
        $data = DB::table('card_users')->where('user_id', $this->id);
        $cardIds = $data->pluck('card_id');

        $cards = Cards::find($cardIds);

        foreach ($cards as $card) {
            $board_hash = Lists::where('list_hash', $card->in_list)->first()->in_board;
            $board = Boards::where('board_hash', $board_hash)->first();

            $card['from_board'] = $board;

            $card['tags'] = $card->tags();
        }

        return $cards;
    }
}
