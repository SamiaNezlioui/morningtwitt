@extends('layouts.app')

@section('title')
MorningTweet - Modifier un Tweet
@endsection

@section('content')



<div class="container">
    <div class="row border rounded-pill border-warning p-4 mb-5 justify-content-center bg-warning">
        <h3 class="mt-3">Tweet!!</h3>

        <form class="col-10 mx-auto m-4" action="{{ route('tweet.update', $tweet) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <i class="fas fa-pen-fancy text-primary fa-2x"></i><label for="content">nouveau Message</label>
                <input required class="container-fluid" type="text" name="content" id="content" value="{{$tweet->content}}">

            <div class="row">
                <div class="col-6 form-group">
                    <i class="fas fa-camera-retro text-primary fa-2x"></i><label for="nom">jouter une nouvelle image</label>
                    @if(Session::get('image'))
                    <input type="text" class="form-control" name="image" id="image" value="{{ Session::get('image') }}">
                    @else
                    <input type="text" class="form-control" name="image" id="image" placeholder="upload d'image ci-dessous">
                    @endif
                </div>

                <div class="col-6 form-group">
                    <i class="fas fa-hashtag text-primary fa-2x"></i><label class="label">ajoute de nouveau tags</label>
                    <div class="control">
                        <input id="tags" type="text" value="{{$tweet->tags}}" class="form-control @error('tags') is-invalid @enderror" required name="tags" autocomplete="tags">
                    </div>
                </div>
            </div>
            <input type="hidden" value="Auth::user()->id" name="user_id">
            <button type="submit" class="btn btn-primary mt-3"> Tweet !</button>
        </form>


    </div>
</div>
@endsection