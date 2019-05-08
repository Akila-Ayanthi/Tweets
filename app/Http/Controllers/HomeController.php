<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Message;
use Illuminate\Support\Facades\DB;


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
        $messages=Message::whereIn('user_id',$followers)->orWhere('user_id',Auth::user()->id)->get();
        return view('home',['messages'=>$messages]);

    }
}

