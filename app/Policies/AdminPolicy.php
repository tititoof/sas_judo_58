<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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
     * Determine if the given user is admin.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function isAdmin(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }
}
