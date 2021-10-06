@extends('layouts.app')

@section('title')
MorningTweet - Accueil
@endsection

@section('content')
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="col-md-10">


            <div class="row justify-content-center p-5">
                <div class="col-8">
                    <img class="mb-3" src="images/logo.jpg" width="200px">
                    <h1 class="mb-3">Bienvenue sur MorningTweet, {{ Auth::user()->nom }} !</h1>
                    <h5 class="font-weight-light"> tweet !!</h5>
                </div>
            </div>

            <!-- *************************************************AJOUTER UN tweet**********************************************-->

            <div class="container">
                <div class="row border rounded-pill border-warning p-4 mb-5 justify-content-center bg-warning">
                    <h3 class="mt-3">Ces ici que sa Tweet!!</h3>

                    <form class="col-10 mx-auto m-4" action="{{ route('tweet.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <i class="fas fa-pen-fancy text-primary fa-2x"></i><label for="content">Message</label>
                            <textarea required class="container-fluid" type="text" name="content" id="content" placeholder="salut !!"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-6 form-group">
                                <i class="fas fa-camera-retro text-primary fa-2x"></i><label for="nom">jouter une image</label>
                                @if(Session::get('image'))
                                <input type="text" class="form-control" name="image" id="image" value="{{ Session::get('image') }}">
                                @else
                                <input type="text" class="form-control" name="image" id="image" placeholder="upload d'image ci-dessous">
                                @endif
                            </div>

                            <div class="col-6 form-group">
                                <i class="fas fa-hashtag text-primary fa-2x"></i><label class="label">ajoute des tags</label>
                                <div class="control">
                                    <input id="tags" type="text" class="form-control @error('tags') is-invalid @enderror" required name="tags" autocomplete="tags">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="Auth::user()->id" name="user_id">
                        <button type="submit" class="btn btn-primary mt-3">Tweet !</button>
                    </form>


                </div>
            </div>

            <h2>Derniers Tweets</h2>
            <img style="width: 20vw" src="images/pond.png" alt="pond">

            <!-- **********************************************AFFICHER LES Tweets**********************************************-->

            @foreach($tweets as $tweet)

            <div class="card mb-4 mt-5 pb-2">
                <div class="card-header bg-warning">
                    <div class="row">
                        <div class="col">
                            @if($tweet->user->image)
                            <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="images/{{ $tweet->user->image }}" alt="imageUtilisateur">
                            @else
                            <img class="m-1 rounded-circle" style="width: 5vw; height:5vw" src="images/default_user.jpg" alt="imageUtilisateur">
                            @endif
                            <h5><a href="{{$tweet->user->pseudo}}">
                                    <strong>{{ $tweet->user->nom }}</strong>
                                </a>
                            </h5>
                        </div>
                        <div class="col m-auto">
                            <h4>#{{ $tweet->tags }} </h4>
                        </div>
                        <div class="col m-auto">
                            <div class="row">posté {{$tweet->created_at->diffForHumans()}}</div>
                            @if ($tweet->created_at != $tweet->updated_at)
                            <div class="row">modifié {{$tweet->updated_at->diffForHumans()}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @if (isset ($tweet->image))
                <div class="card-img p-3">
                    <img class="m-1" style="width: 45vw" src="images/{{ $tweet->image }}" alt="imageTweet">
                </div>
                @endif
                <div class="card-body ml-5 mr-5">
                    <p>{{ $tweet->content }}</p>

                    <div class="col"><a class="btn btn-info" onclick="document.getElementById('formulairecommentaire{{$tweet->id}}').style.display = 'block'">Commenter
                        </a>
                    </div>

                    <!--si l'utilisateur repond a la condition de policies auth les boutton seront afficher-->
                    @can('update', $tweet)
                    <a href="{{route('tweet.edit', $tweet)}}"> <button class="btn btn-secondary">Modifier le tweet</button></a>
                    @endcan
                    @can('delete', $tweet)
                    <form action="{{route('tweet.destroy',$tweet)}}" method='POST'>
                        @csrf
                        <!-- creé un input qui verifie le token qui corespend au formulaire et le id de la session-->
                        @method('DELETE')
                        <button class="btn btn-danger">Supprimer le tweet</button>
                    </form>
                    @endcan
                </div>
                <!-- **********************************************AJOUTER UN COMMENTAIRE**********************************************-->
                <div style="display:none" class="col p-3 mb-2" id="formulairecommentaire{{$tweet->id}}">
                    <form class="w-50 m-auto" action="{{ route('comment.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="content">Tape ton commentaire</label>
                            <textarea required class="container" type="text" name="content" id="content"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tags"># Ajoute des tags #</label>
                            <input required class="container" type="text" name="tags" id="tags"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4 form-group">
                                <label for="nom">image (facultatif)</label>
                                @if(Session::get('image'))
                                <input type="text" class="form-control" name="image" id="image" readonly="readonly" value="{{ Session::get('image') }}">
                                @else
                                <input type="text" class="form-control" name="image" id="image" readonly="readonly" placeholder="upload d'image ci-dessous">
                                @endif
                            </div>
                            <input class="form-control" type="hidden" id="tweet_id" name="tweet_id" value="{{$tweet->id}}">
                        </div>
                        <button class="btn btn-danger" onclick="document.getElementById('formulairecommentaire{{$tweet->id}}').style.display = 'none'">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-warning">Valider</button>
                    </form>
                </div>
            </div>
            <!-- ********************************** PARTIE COMMENTAIRE ******************************************** -->
            @foreach( $tweet->comments as $comment)
            <div class="container w-75 mb-4">
                <div class="card mb-2">

                    <div class="card-header navbar-dark bg-primary text-light">
                        <div class="row">
                            <div class="col">
                                @if($comment->user->image)
                                <img class="m-1 rounded-circle" style="width: 3vw; height:3vw" src="images/{{ $comment->user->image }}" alt="imageUtilisateur">
                                @else
                                <img class="m-1 rounded-circle" style="width: 3vw; height:3vw" src="images/default_user.jpg" alt="imageUtilisateur">
                                @endif
                                <h5><a style="text-decoration: none;" class="text-warning" href="{{ route ('user.profil', $comment->user_id) }}">
                                        <strong>{{ $comment->user->nom }}</strong>
                                    </a>
                                </h5>
                            </div>
                            <div class="col m-auto">
                                @if ($comment->tags !== null)
                                <h5>#{{ $comment->tags }} </h5>
                                @endif
                            </div>
                            <div class="col m-auto">
                                <div class="row">posté {{$tweet->created_at->diffForHumans()}}</div>
                                @if ($comment->created_at != $comment->updated_at)
                                <div class="row">modifié {{$tweet->updated_at->diffForHumans()}}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $comment->content }}
                        @if ($comment->image !== null)
                        <div class="card-img p-3">
                            <img style="width: 15vw" src="images/{{ $comment->image }}" alt="imageTweet">
                        </div>
                        @endif

                        <div class="row mb-2">
                            <div class="col">
                                @can('update', $comment)
                                <a href="{{ route('comment.edit', $comment) }}">
                                    <button class="btn btn-secondary">Modifier</button>
                                </a>
                                @endcan
                            </div>
                            @can('delete', $comment)
                            <form action="{{route('comment.destroy',$comment)}}" method='POST'>
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Supprimer le commentaire</button>
                            </form>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach

            <div class="col-md-2 offset-md-5">
                {{ $tweets->links() }}
            </div>

        </div>
    </div>
</div>
@endsection