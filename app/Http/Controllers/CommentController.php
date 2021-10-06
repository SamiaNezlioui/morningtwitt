<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:5|max:250',
        ]);
        $user = Auth::user();
        $comment = new Comment;

       $this->authorize('create', $comment);

        $comment->user_id = $user->id;
        $comment->content = $request->input('content');
        $comment->tags = $request->input('tags');
        $comment->tweet_id = $request->input('tweet_id');

        $comment->save();
        return redirect()->route('home');
    }
   
    public function edit(Comment $comment)
    {
        return view('comment.edit', ['comment' => $comment]);
    }

    public function update(Request $request, Comment $comment)
    //transmettre le $comment depui l'action du formuliare de edit par la route update
    //$request trasmet les donnée dans les fonctions qui passe par des POST
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|min:5',
        ]);
        $comment->update($request->except('_token'));
    return redirect()->route('home')->with('message', 'Le commentaire a bien été modifié');

       // $comment->content = $request->input('content');//$comment c'est un Objets de l'instance de la class comment
       // $comment->image = $request->input('image');// ->pour acceder au contenu image(attribut) de l'objet $comment
       // $comment->tags = $request->input('tags');
       //$comment->save();//equivalent a la requet update de SQL
    }

     // supprimer le comment
     public function destroy(Comment $comment)
     {
        $this->authorize('delete', $comment);

         $comment->delete();
         return redirect()->route('home')->with('message', 'Le commentaire est bien supprimé');
     }
}
