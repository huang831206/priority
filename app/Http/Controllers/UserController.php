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
        $user_id = Auth::id();


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
            $user->priority = $request['priority'];
            $user->save();
            $data['success'] = true;
        }

        return response()->json($data);

    }
}
