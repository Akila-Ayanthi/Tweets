<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Notifications\NewFollower;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($user){
       $user=User::findOrFail($user);
        $messages=Message::where('user_id',$user->id)->get();
        return view('profile',['user'=>$user,'messages'=>$messages]); 
    }

    public function followOrUnfollow(Request $request){
        //dd($request);
        if($request->follow){
            $user=User::findOrFail($request->user);
            Auth::user()->following()->attach($user->id);
            $user->notify(new NewFollower(Auth::user()));
        }
        else{
            $user=User::findOrFail($request->user);
            Auth::user()->following()->detach($user->id);
        }
        return redirect('/u/'.$user->id);

    }
}
