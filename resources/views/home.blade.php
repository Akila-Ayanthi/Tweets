@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Recent Updates</div>

                <div class="card-body">
                    <form action="/postMessage" method="post">
                    {{csrf_field()}}
                        <textarea name="post" id="post" rows="10" class="form-control" placeholder="What's on your mind?"></textarea>
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
                            {{$message->created_at}}
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
                            <h5>
                                {{$notification->data['user_name']}} started following you
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
