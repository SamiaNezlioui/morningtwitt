<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // pour afficher une ressource (profil) un user 
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // pour afficher le formulaire de la modification
    public function edit($id)
    {
        $user = Auth::user();
        return view('user/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // valider les modification
    public function update(Request $request, User $user)
    {
        //verifier les champs avec le validate
        $request->validate([
            'prenom' => 'required|min:3|max:50',
            'nom' => 'required|min:3|max:50',
            'email' => 'required|min:7|max:50',
        ]);
        //on recuper les données et les attribu au user
        // $user = Auth::user();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->pseudo = $request->input('pseudo');
        $user->email = $request->input('email');
        $user->image = $request->input('image');

        $user->save(); //on sauvgarde les changement et redirige avec un message de cofirmation
        return redirect()->route('home')->with('message', 'Le compte a bien été modifié');
    }


    // ******fonctiont pour modifier le mot de passe de l'Utilisateur

    public function updatepassword(Request $request, User $user) // $request contient ce qui est saisi dans le formulaire
    {
        //verifier les champs avec le validate
        $request->validate([
            'password' => 'required',
            'newpassword' => [
                'required', 'confirmed', // le champ confiremer avec le même password (password_confirm)
                Password::min(8) // minimum 8 caractères
                    ->mixedCase() // Require at least one uppercase and one lowercase letter...
                    ->letters()  // Require at least one letter...
                    ->numbers() // Require at least one number...
                    ->symbols() // Require at least one symbol...
            ],
        ]);

        $passwordOld = $request->input('password');
        //comparer le mot de passe actuel et le mot de passe actuel en base de donnée
        if (Hash::check($passwordOld, $user->password)) {
            //hacher le nouveau mot de passe saisi pour l'utilisateur
            $newHashPassword = Hash::make($request->input('newpassword'));
            $user->password =  $newHashPassword; // on attribut le mot de passe hacher(nouveau) a l'utilisateur
            $user->save();
            return redirect()->route('home')->with('message', 'Le compte a bien été modifié');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'mot de passe incorrect']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // supprimer l'utulisateur (user)
    public function destroy($id)
    {
        //
    }
}
