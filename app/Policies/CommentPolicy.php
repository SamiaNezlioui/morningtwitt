<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
         if(Auth::user()){
             return true;
         }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        if($user -> id === $comment->user_id){
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Comment $comment)
    {
        // possible de supprimer un message, ce qui supprimera automatiquement tous les commentaires associés.
        if($user->id === $comment->user_id || $user->id === $comment->tweet->user_id){
            return true;
        }
    }

}
