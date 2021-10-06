<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Comment;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::resource('/comment', App\Http\Controllers\CommentController::class);

//route user (la partie public)
Route::resource('/user', App\Http\Controllers\UserController::class)->except('create','index','store');
Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'profil'])->name('user.profil');

// route Tweet message
Route::resource('/tweet', App\Http\Controllers\TweetController::class)->except('create','index');

//'updatepassword' la fonction du controlleur
Route::put('/user/updatepassword/{user}',[App\Http\Controllers\UserController::class,'updatepassword'])->name('updatepassword');

// pour le telechargement de l'image

// la route concernat la partie ou le USER qui est L'auteur d'un comment peut supprimer ou modifier sont commentaire
//Route::delete('users/{user}/destroy', 'User\UserController@destroy')->name('user.destroy');



