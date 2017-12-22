<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lists extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function scopeCards($query)
    {

        $cardIds = DB::table('list_cards')->where('list_id', $this->id)->pluck('card_id');

        return Cards::find($cardIds);
    }
}
