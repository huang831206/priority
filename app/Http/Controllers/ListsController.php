<?php

namespace App\Http\Controllers;

use App\Boards;
use App\Lists;
use App\Cards;
use App\User;
use App\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function show(Lists $lists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lists $lists)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'board_hash' => 'string',
            'lists' => 'array'
        ]);

        $data['success'] = false;

        if($validator->fails()){
            $data['errors']['type'] = 'validation';
            $data['errors']['message']= $validator->errors();
            return Response()->json($data);
        }

        $lists = $request->json('lists');
        // dd(json_decode($request->getContent()));
        // dd($request);
        $board_hash = $request->json('board_hash');
        foreach ($lists as $list) {
            // update lists
            if( DB::table('lists')->where('list_hash', $list['list_hash'])->get()->isEmpty() ){
                // if list not fount, create one
                $listId = DB::table('lists')->insertGetId([
                    'list_hash' => $list['list_hash'],
                    'name' => $list['name'],
                    'in_board' => $board_hash,
                    'pos' => $list['pos'],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            } else {
                // list exists
                DB::table('lists')->where('list_hash', $list['list_hash'])
                    ->update([
                        'name' => $list['name']
                    ]);
                // find list id by list hash
                $listId = DB::table('lists')->select('id')->where('list_hash', $list['list_hash'])->first()->id;

            }

            // $listId: list id which is currently working on

            // delete old relations data
            DB::table('list_cards')->where('list_id', $listId)->delete();

            // if this list has no cards, leave
            if( count($list['cards']) == 0 ){
                continue;
            }

            foreach ($list['cards'] as $card) {
                // update cards
                $cardData = [
                    'name' => $card['name'],
                    'in_list' => $list['list_hash'],
                    'point' => $card['point'],
                    'pos' => $card['pos'],
                    'content' => $card['content'],
                ];

                if( DB::table('cards')->where('card_hash', $card['card_hash'])->get()->isEmpty() ){
                    // if card not found, create one
                    $cardData['card_hash'] = $card['card_hash'];
                    $cardData['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $cardData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    $cardId = DB::table('cards')->insertGetId($cardData);
                } else {
                    // card exists
                    DB::table('cards')->where('card_hash', $card['card_hash'])->update($cardData);
                    $cardId = DB::table('cards')->select('id')->where('card_hash', $card['card_hash'])->first()->id;
                }

                // $cardId: card id which is currently working on

                // update list-cards
                // insert new relations data
                DB::table('list_cards')->insert([
                    'list_id' => $listId,
                    'card_id' => $cardId,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);


                DB::table('card_users')->where('card_id', $cardId)->delete();
                // if this card has any users
                if( count($card['users']) != 0 ) {
                    // update card users
                    $cardUserData = [];
                    foreach ($card['users'] as $user) {
                        $cardUserData[] = [
                            'card_id' => $cardId,
                            'user_id' => $user['id'],
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }
                    DB::table('card_users')->insert($cardUserData);
                }


                DB::table('card_tags')->where('card_id', $cardId)->delete();
                // if this card has any tags
                if( count($card['tags']) != 0 ) {
                    // update card tags
                    $cardTags = [];
                    foreach ($card['tags'] as $tag) {
                        $cardTags[] = $tag['tag_hash'];
                    }
                    // find tags ids by hashes
                    $tagIds = DB::table('tags')->select('id')->whereIn('tag_hash', $cardTags)->get()->pluck('id')->all();
                    $cardTagData = [];
                    if( count($tagIds) != 0 ){
                        foreach ($tagIds as $tid) {
                            $cardTagData[] = [
                                'card_id' => $cardId,
                                'tag_id' => $tid,
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ];
                        }
                        DB::table('card_tags')->insert($cardTagData);
                    }
                }
            }

        }

        $data['success'] = true;
        return response()->json($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lists  $lists
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lists $lists)
    {
        //
    }
}
