<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cards extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // return Illuminate\Support\Collection instead of Illuminate\Database\Eloquent\Collection
    public function scopeTags()
    {

        $tagIds = DB::table('card_tags')->where('card_id', $this->id)->pluck('tag_id');

        // return Tags::find($tagIds);
        return DB::table('tags')->whereIn('id', $tagIds)->get(['name', 'color', 'tag_hash']);
    }

    // return Illuminate\Support\Collection instead of Illuminate\Database\Eloquent\Collection
    public function scopeUsers()
    {

        $userIds = DB::table('card_users')->where('card_id', $this->id)->pluck('user_id');

        // return User::find($userIds);
        return DB::table('users')->whereIn('id', $userIds)->get(['id', 'name']);
    }
}
