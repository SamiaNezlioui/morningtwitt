<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profil',[App\Http\Controllers\HomeController::class, 'index'])->name('profil');
Route::get('/comment',[App\Http\Controllers\HomeController::class, 'index'])->name('comment');
Route::get('/quack',[App\Http\Controllers\HomeController::class, 'index'])->name('quack');

Route::resource('/user', App\Http\Controllers\UserController::class)->except('create','index','store');

Route::put('/user/updatepassword/{user}',[App\Http\Controllers\UserController::class,'updatepassword'])->name('updatepassword');//'updatepassword' la fonction du controlleur


