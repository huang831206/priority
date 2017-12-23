<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display logged in user info.
     */

    public function __construct()
    {

    }


    public function priority() {
        $user = Auth::user();

        $data = new \stdClass();
        $data->priority = json_decode($user->priority);
        $data->inbox = $user->cards()->all();
        $data->name = 'Inbox';

        return view('priority')->with(['board' => $data]);
    }

    public function getPriorityJSON() {

        $user = Auth::user();

        return $user->priority;
    }

    public function updatePriorityJSON(Request $request) {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'priority' => 'JSON'
        ]);

        $data['success'] = false;

        if($validator->fails()){
            $data['errors']['type'] = 'validation';
            $data['errors']['message']= $validator->errors();
            return Response()->json($data);
        } else {
            $user->priority = $request->getContent();
            $user->save();
            $data['success'] = true;
        }

        return response()->json($data);

    }
}
