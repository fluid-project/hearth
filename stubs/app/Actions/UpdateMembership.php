<?php

namespace App\Actions;

use App\Models\User;
use App\Rules\NotLastAdmin;
use Hearth\Models\Membership;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateMembership
{
    /**
     * Update the role for the given user in a membershipable.
     *
     * @param  User  $user
     * @param Membership $membership
     * @param  string  $role
     * @return void
     */
    public function update($user, Membership $membership, string $role)
    {
        Gate::forUser($user)->authorize('update', $membership->membershipable());

        $validator = Validator::make(
            [
                'role' => $role,
                'membership' => $membership,
            ],
            [
                'role' => [
                    'required',
                    'string',
                    Rule::in(config('hearth.organizations.roles')),
                ],
            ]
        );

        $validator->sometimes(
            'membership',
            [new NotLastAdmin()],
            function ($input) {
                return $input->role != 'admin';
            }
        );

        $validator->validate();

        $membership->membershipable()->users()->updateExistingPivot($membership->user->id, [
            'role' => $role,
        ]);

        flash(__('membership.role_update_succeeded', [
            'user' => $membership->user->name,
        ]), 'success');
    }
}
