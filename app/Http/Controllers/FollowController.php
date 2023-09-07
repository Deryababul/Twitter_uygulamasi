<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\FollowRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function sendFollowRequest(User $receiver,Request $request)
{
    Auth::user()->followRequests()->create([
        'receiver_id' => $receiver->id,
        'sender_id' => $request->sender_id
    ]);

    return response([
        'message' => 'success',
        'status' => 'takip isteği gönderildi'
    ]);
}
public function acceptFollowRequest(  Request $request)
{
    $sender = $request->sender_id;
    $users = FollowRequest::where('sender_id', '=', $sender)->get();
    foreach ($users as $user) {
        $user->accepted = true;
    }
    $user->save();
    $follower =Follower::create([
        'follower_id' => $sender,
        'following_id' => Auth::user()->id
    ]);
    return response([
        'message' => 'success',
        'status' => 'takip isteği kabul edildi'
    ]);
}
public function rejectFollowRequest(Request $request)
{
    $sender = $request->sender_id;
    $users = FollowRequest::where('sender_id', '=', $sender)->get();
    foreach ($users as $user) {
        $user->accepted = false;
    }
    $user->delete();

    return response([
        'message' => 'success',
        'status' => 'takip isteği reddedildi'
    ]);
}
public function followers(){
    $followers =Follower::all();
    return $followers;
}
public function count(){
    $followingId = Auth::user()->id; 
    $veri = Follower::where('following_id', $followingId)->get(); 
    $followerCount = count($veri); 
    return $followerCount;


}

}