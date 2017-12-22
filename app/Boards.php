<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lists;
use App\BoardResources;

class Boards extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function scopeBoardResources($query, $type)
    {
        $rawBoardResources = BoardResources::where('resource_type', $type)->where('board_id', $this->id)->get();
        return $rawBoardResources;
    }

    public function scopeLists($query)
    {
        $rawBoardResources = $query->boardResources('list');
        $listIds = $rawBoardResources->pluck('resource_id');
        return Lists::find($listIds)->except(['created_at', 'updated_at']);
    }

    public function scopeUsers($query)
    {
        $rawBoardResources = $query->boardResources('user');
        $userIds = $rawBoardResources->pluck('resource_id');
        return User::find($userIds);
    }

    public function scopeTags($query)
    {
        $rawBoardResources = $query->boardResources('tag');
        $tagIds = $rawBoardResources->pluck('resource_id');
        return Tags::find($tagIds);
    }

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'board_hash';
    }

}
