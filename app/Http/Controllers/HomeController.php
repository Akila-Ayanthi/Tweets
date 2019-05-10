<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$messages=DB::table('messages')->where('user_id',Auth::user()->id)->get();

        $followers=Auth::user()->following->pluck('id');
        //dd($followers);
        $messages=Message::whereIn('user_id',$followers)->orWhere('user_id',Auth::user()->id)->get();

        foreach(Auth::user()->unreadNotifications as $notification){
            $notification->markAsRead();
            //dd($notification);
        }
        //dd($messages);
        return view('home',['messages'=>$messages]);
    }

    public function postMessage(Request $request){
        $messages=new Message;
        $messages->body=$request->input('post');
        $messages->user_id=Auth::user()->id;
        $messages->save();

        $followers=Auth::user()->following->pluck('id');
        $messages=Message::whereIn('user_id',$followers)->orWhere('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('home',['messages'=>$messages]);

    }

    public function searchUser(Request $request){
       $searchedUser=Input::get('searchuser');
       $userList=User::where('name','LIKE','%'.$searchedUser.'%')->get();
        if(count($userList)>0){
            $user=$userList->first();
            $messages=Message::where('user_id',$user->id)->get();
        return view('profile',['user'=>$user,'messages'=>$messages]); 
        }
        else{

        }
     

    }
}

