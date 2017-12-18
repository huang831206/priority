<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lists;

class Boards extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // TODO: extract this
    public function boardResources()
    {
        return $this->hasMany('App\BoardResources', 'resource_id', 'id');
    }

    public function scopeLists($query)
    {
        $rawBoardResources = $this->boardResources()->where('resource_type', 'list');
        $listIds = $rawBoardResources->pluck('id');

        return Lists::find($listIds);
    }

}
