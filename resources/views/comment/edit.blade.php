@extends ('layouts.app')

@section('title')
Tweet - Modifier un commentaire
@endsection

@section('content')

<main class="container">

    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4 text-center">
            <form class="col-12 mx-auto" action="{{ route('comment.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')<!-- parce que c'est un udate pas une insertion de nouvelle donnée-->
                
                <!-- le prés remplissage des champs ce fait gâce $comment quand fait passer par la route-->
                <div class="form-group">
                    <label for="content">Nouveau texte</label>
                    <input required type="text" class="form-control" name="content" value="{{ $comment->content }}" id="content">
                </div>

                <div class="form-group">
                    <label for="tags">Nouveau tag</label>
                    <input type="text" class="form-control" name="tags" value="{{ $comment->tags }}" id="tags">
                </div>

                <div class="form-group">
                    <label for="image">Nouvelle image</label>
                    @if(Session::get('image'))
                    <input type="text" class="form-control" name="image" id="image" value="{{ Session::get('image') }}">
                    @else
                    <input type="text" class="form-control" name="image" placeholder="upload d'image ci-dessous" value="{{ $comment->image }}" id="image">
                    @endif
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="{{ $comment->id }}">
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>

           </div>
        <div class="col-4">
        </div>
    </div>
</main>

@endsection