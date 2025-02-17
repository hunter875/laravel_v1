<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can access admin functionalities.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function accessAdmin(User $user)
    {
        return $user->role_id === 1; // Assuming role_id 1 is for admin
    }
}
