@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> 
                    {{$user->name}}
                    
                    <form action="/follow" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="user" value="{{$user->id}}">
                        @if(Auth::user()->isFollowing($user))
                            <input type="submit" name="unfollow" value="Unfollow" class="btn btn-danger float-right">
                        @else
                            <input type="submit" name="follow" value="Follow" class="btn btn-primary float-right">
                        @endif

                    </form>
                </div>
                <div class="card-body">
                @foreach($messages as $message)
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
    </div>
</div>
@endsection
