<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

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
    public function index()//page d'acceuil du site 
    {
        return view('index');
    }

    public function home()//la page qui s'affiche une fois connecter
    {
        //affichage des messges les olus recent les 1à premier
        $tweets = Tweet::orderByDesc('created_at')->latest()->paginate(10);
        $tweets->load('comments');// pour charger la function comment()
        return view('home', compact('tweets'));

           }
}
