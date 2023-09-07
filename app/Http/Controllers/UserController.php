<?php

namespace App\Http\Controllers;

use App\Http\Resources\FollowResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TweetResource;
use App\Models\Follower;
use App\Models\tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request){
        try{
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation failed',
                    'errors' => $validateUser->errors(),
                ]);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'user completed',
                // 'user'=> new UserResources($user),
                'token'=> $user->createToken("API TOKEN")->plainTextToken, //plainText Token düz metin değerine çevirir

            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
        }
        public function login(Request $request){
            try{
                $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if($validateUser->fails()){
                return response()->json([
                    'status'=> false,
                    'message'=>'validation error',
                    'erros'=>$validateUser->errors()
                ]);
            }
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];
            if(!(Auth::guard('web')->attempt($credentials, false, false)) //kimlik bilgileriyle eşleşen kullanıcıyı sorgular
            ){
                return response()->json([
                    'status'=>false,
                    'message'=>'email password does not match with our record',]);
                
            } 
    
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status'=> true,
                'message'=>'login completed',
                'token'=> $user->createToken("API TOKEN")->plainTextToken //plainText Token düz metin değerine çevirir
    
            ]);
            
            }catch(\Throwable $th){
                return response()->json([
                    'status'=>false,
                    'message' => $th->getMessage()
                ]);
            }
        }

        public function user(){
            $user = Auth::user();
            $tweets =$user->tweets;
            // $followers =Follower::all();
            $followers= $user->followers;
            $followings= $user->followings;
            return response()->json([
                'user' => new ProfileResource($user),
                'tweets' => TweetResource::collection($tweets),
                'followers' => FollowResource::collection($followers),
                'followings' => FollowResource::collection($followings),        
            ]);    }
}