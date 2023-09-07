<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\FollowRequest;
use App\Models\tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TweetController extends Controller
{
    
    public function create(Request $request)
{
    if (Auth::check()) {
        $validator = Validator::make($request->all(), [
            'tweet' => 'required|max:180',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user_id = Auth::id();
        $tweet = Tweet::create([
            'user_id' => $user_id,
            'tweet' => $request->tweet,
        ]);

        return response()->json([
            'user_id' => $user_id,
            'tweet' => $request->tweet,
        ]);
    } else {
        return response()->json(['error' => 'Bu işlemi yapmak için oturum açmalısınız.'], 403);
    }
}
    public function delete(tweet $id){
        if (Auth::check()) {
            $id->delete();
        }
        return response()->json([
            'message' => 'tweet deleted'
        ]);
    }

    public function list(){
        $list =tweet::orderBy('created_at','desc')->get();
        return $list;
    }
}
