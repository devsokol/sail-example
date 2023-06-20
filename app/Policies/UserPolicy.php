<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $loggedInUser, User $targetUser): bool
    {
        return $loggedInUser->id !== $targetUser->id;
    }
}
