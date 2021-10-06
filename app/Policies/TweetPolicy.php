<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
class TweetPolicy
{
    use HandlesAuthorization;

    public function before(User $user){
         if($user->isAdmin()){
            return true;
         }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create()
    {
        //si le user est connecter (pour cree un tweet)
        if(Auth::user()){
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, tweet $tweet)
    {
        //on compare l ID du USER Connecter avec l 'id d'user qui a posté le tweet
       if($user ->id === $tweet -> user_id){
        return true;
       }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, tweet $tweet)
    {
     if ($user->id === $tweet -> user_id){
         return true;
     }
    }
}
