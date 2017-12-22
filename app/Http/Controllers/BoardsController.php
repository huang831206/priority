<?php

namespace App\Http\Controllers;

use App\Boards;
use App\BoardResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $boardIds = BoardResources::where('resource_type', 'user')
                                    ->where('resource_id', $user->id)
                                    ->get()->pluck('board_id');

        $data = Boards::find($boardIds);
        return view('home')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Boards  $boards
     * @return \Illuminate\Http\Response
     */
    public function show(Boards $board)
    {
        $data = $board;

        $data['users'] = $board->users();

        $data['tags'] = $board->tags();

        $data['lists'] = $board->lists();

        foreach ($data['lists'] as $list) {
            $list['cards'] = $list->cards();

            foreach ($list['cards'] as $card) {
                $card['tags'] = $card->tags();
                $card['users'] = $card->users();
            }
        }

        return view('board')->with(['board' => $board]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Boards  $boards
     * @return \Illuminate\Http\Response
     */
    public function edit(Boards $boards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Boards  $boards
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Boards $boards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Boards  $boards
     * @return \Illuminate\Http\Response
     */
    public function destroy(Boards $boards)
    {
        //
    }
}
