<?php

namespace App\Actions;

use App\Rules\NotLastAdmin;
use Hearth\Models\Membership;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DestroyMembership
{
    /**
     * Destroy the given membership.
     *
     * @param  mixed  $user
     * @param Membership $membership
     * @return void
     */
    public function destroy(mixed $user, Membership $membership)
    {
        Gate::forUser($user)->authorize('update', $membership->membershipable());

        $validator = Validator::make(
            [
                'membership' => $membership,
            ],
            []
        );

        $validator->sometimes(
            'membership',
            [new NotLastAdmin()],
            function ($input) {
                return $input->membership->role === 'admin';
            }
        );

        $validator->validate();

        $membership->membershipable()->users()->detach($membership->user->id);

        flash(__('membership.remove_member_succeeded', [
            'user' => $membership->user->name,
            'membershipable' => $membership->membershipable()->name,
        ]), 'success');
    }
}
