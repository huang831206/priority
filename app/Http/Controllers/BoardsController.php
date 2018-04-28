<?php

namespace App\Http\Controllers;

use App\Boards;
use App\BoardResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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


        $data['boards'] = Boards::find($boardIds);
        foreach ($data['boards'] as $board) {
            $board->user_count = BoardResources::where('resource_type', 'user')->where('board_id', $board->id)->count();
        }

        $data['priority'] = $user->priority;
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
        $data['success'] = false;

        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'board_hash' => 'string'
            ]);

            if($validator->fails()){
                $data['errors']['type'] = 'validation';
                $data['errors']['message']= $validator->errors();
                return response()->json($data);
            }

            $data = $request->json()->all();
            $board_hash = $data['board_hash'];

            // create a new board
            $boardId = DB::table('boards')->insertGetId([
                'name' => $data['name'],
                'board_hash' => $board_hash,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // set creater to default user in board
            DB::table('board_resources')->insert([
                'board_id' => $boardId,
                'resource_type' => 'user',
                'resource_id' => $user->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            // set some more dummy users
            DB::table('board_resources')->insert([
                [
                    'board_id' => $boardId,
                    'resource_type' => 'user',
                    'resource_id' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],[
                    'board_id' => $boardId,
                    'resource_type' => 'user',
                    'resource_id' => 4,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],[
                    'board_id' => $boardId,
                    'resource_type' => 'user',
                    'resource_id' => 5,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],[
                    'board_id' => $boardId,
                    'resource_type' => 'user',
                    'resource_id' => 6,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            ]);

            $colors = ['red', 'orange', 'yellow', 'olive', 'green', 'teal', 'blue', 'purple', 'pink', 'brown', 'grey'];
            $tagData = [];
            foreach ($colors as $color) {
                $tagData[] = [
                    'tag_hash' => $this->uniqueId(),
                    'color' => $color,
                    'in_board' => $board_hash,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
            }
            // also create default tags
            DB::table('tags')->insert($tagData);

            // get the just inserted tag ids
            $tagIds = DB::table('tags')->select('id')
                ->where('in_board', $board_hash)
                ->get()->pluck('id')->all();


            $tagRelationData = [];
            foreach ($tagIds as $tid) {
                $tagRelationData[] = [
                    'board_id' => $boardId,
                    'resource_type' => 'tag',
                    'resource_id' => $tid,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
            }
            // insert them to board_resources
            DB::table('board_resources')->insert($tagRelationData);

            $data['success'] = true;
            $data['data']['board_hash'] = $board_hash;

        } catch (Exception $e) {

        } finally {
            return response()->json($data);
        }
    }

    private function uniqueId() {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $str = '';
        for ($i = 0; $i < 12; $i++) {
            $str .= $chars[rand(0,61)];
        }
        return $str;
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
