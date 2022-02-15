<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Methode qui vérifie si l'utilisateur peur voir la liste de tous les autres utilisateur
     *
     * @param User $user L'utilisateur en question, A verifier l'access
     * @return bool true si l'utilisateur a l'acces, false sinon
     */
    public function viewAny(User $user) : bool
    {
        if ($user->estSuperAdmin()) return true;
        else return false;
    }

    public function update(User $user, Post $post)
    {
        //return $user->id === $post->user_id;
    }
}
