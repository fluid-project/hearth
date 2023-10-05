<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return ! $user->joinable && $user->organizations->isEmpty()
            ? Response::allow()
            : Response::deny(__('You already belong to an organization, so you cannot create a new one.'));
    }

    /**
     * Determine whether the user can join the model.
     */
    public function join(User $user, Organization $organization): Response
    {
        return ! $user->joinable && $user->organizations->isEmpty()
            ? Response::allow()
            : Response::deny(__('You cannot join this organization.'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organization $organization): Response
    {
        return $user->isAdministratorOf($organization)
            ? Response::allow()
            : Response::deny(__('You cannot edit this organization.'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Organization $organization): Response
    {
        return $user->isAdministratorOf($organization)
            ? Response::allow()
            : Response::deny(__('You cannot delete this organization.'));
    }
}
