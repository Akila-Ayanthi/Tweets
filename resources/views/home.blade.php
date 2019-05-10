@extends('layouts.app')

@section('content')
<div class="container">
        <div class="col-md-8 ">
        <form class="form-inline" action="/searchUser" method="post">
        {{csrf_field()}}
      <input class="form-control mr-sm-2" size="50" type="search" placeholder="Search" aria-label="Search" name="searchuser">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    
        </div> 
        <div class="row justify-content-center">
  
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Recent Updates</div>

                <div class="card-body">
                    <form action="/postMessage" method="post">
                    {{csrf_field()}}
                        <textarea name="post" id="post" rows="5" class="form-control" placeholder="What's on your mind?"></textarea>
                        <input type="submit" value="Post" class="btn btn-primary">
                    </form>
                </div>
                <div class="card-body">
                    @foreach($messages as $message)
                    <h5><a href="/u/{{$message->user->id}}">
                        {{$message->user->name}}
                    </a></h5>
                        <h5>
                            {{$message->body}}
                        </h5>
                        <small>
                            {{$message->created_at->diffForHumans()}}
                        </small>
                        <hr>
                    
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Notifications
                </div>
                <div class="card-body">
                        @foreach(Auth::user()->notifications as $notification)
                            <h5><a href="/u/{{$notification->data['user_id']}}">
                                    {{$notification->data['user_name']}} started following you
                                </a>
                            </h5>
                            <small>
                                {{$notification->created_at->diffForHumans()}}
                            </small>

                        @endforeach
                </div>  
            </div>
            
        </div>
    </div>
</div>
@endsection
