<?php

namespace App\Policies;

use App\Models\Core\User;
use App\Models\Core\Listing;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListingPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Listing $listing)
    {
        return $user->id === $listing->user_id;
    }

    public function delete(User $user, Listing $listing)
    {
        return $user->id === $listing->user_id;
    }
}
