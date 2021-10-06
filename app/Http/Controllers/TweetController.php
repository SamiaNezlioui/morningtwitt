<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tweet;


class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //************************Affiche l'accueil d'un e ressource 
    public function index()
    {
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //*********************Afficher le formulaire 
    public function create()
    {
                 //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // la validation et l'enregistrement du formulaire dans la base des données

    public function store(Request $request)
    {
       
        $request->validate([
            'content' => 'required|min:5|max:250',
            'tags' => 'required|min:5|max:20',

          //  'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $imageName = "";
        if ($request->image) {
            $imageName = time() . '.'  . $request->image->extension();
            $request->image->move(public_path('image'), $imageName);
            $request->image = '/image/' . $imageName;
        }
       
        $user_id = Auth::user()->id;
        $tweet = new Tweet;

      $this->authorize('create', $tweet);

        $tweet->user_id = $user_id;
        $tweet->content = $request->input('content');
        $tweet->image = $request->input('image');
        $tweet->tags = $request->input('tags');
       
        $tweet->save();
         return redirect()->route('home')
           ->with('message', 'message ajouter avec succée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // pour afficher une ressource (profil) un user 
    public function show(Tweet $tweet)
    {
        return view('tweet.show', ['tweet' => $tweet]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // pour afficher le formulaire de la modification
    public function edit(Tweet $tweet)
    {
        return view('tweet/edit', ['tweet' => $tweet]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //***************** valider les modification
    public function update(Request $request, Tweet $tweet)
    {
        $this->authorize('update', $tweet);
        $request->validate([
            'content' => 'required|min:5|max:500',
            'tags' => 'min:3|max:50',
        ]);

        $tweet->content = $request->input('content');
        $tweet->image = $request->input('image');
        $tweet->tags = $request->input('tags');

        $tweet->save();
        return redirect()->route('home')->with('message', 'Le Tweet est modifié avec succée');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // supprimer le tweet
    public function destroy(Tweet $tweet)
    {
       $this->authorize('delete', $tweet);

        $tweet->delete();
        return redirect()->route('home')->with('message', 'Le tweet est bien supprimé');
    }
}
