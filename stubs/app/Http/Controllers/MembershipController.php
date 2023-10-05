<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMembershipRequest;
use App\Rules\NotLastAdmin;
use Hearth\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    /**
     * Show the form for editing the specified membershipable member.
     *
     * @return mixed
     */
    public function edit(Membership $membership)
    {
        $roles = [];

        foreach (config('hearth.organizations.roles') as $role) {
            $roles[] = ['value' => $role, 'label' => __('roles.'.$role)];
        }

        return view('memberships.edit', [
            'membership' => $membership,
            'user' => $membership->user,
            'membershipable' => $membership->membershipable(),
            'roles' => $roles,
        ]);
    }

    /**
     * Update the given member's role.
     */
    public function update(UpdateMembershipRequest $request, Membership $membership): RedirectResponse
    {
        $validated = $request->validated();

        $membership->membershipable()->users()->updateExistingPivot($membership->user->id, [
            'role' => $validated['role'],
        ]);

        if ($request->user()->id === $membership->user->id && $request->input('role') !== 'admin') {
            return redirect(
                \localized_route($membership->membershipable()->getRoutePrefix().'.show', $membership->membershipable())
            );
        }

        return redirect(
            \localized_route($membership->membershipable()->getRoutePrefix().'.edit', $membership->membershipable())
        );
    }

    /**
     * Remove the given member from the organization.
     */
    public function destroy(Request $request, Membership $membership): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('update', $membership->membershipable());

        $validator = Validator::make(
            [
                'membership' => $membership,
            ],
            []
        );

        $validator->sometimes(
            'membership',
            [new NotLastAdmin($membership)],
            function ($input) {
                return $input->membership->role === 'admin';
            }
        );

        $validator->validate();

        $membership->membershipable()->users()->detach($membership->user->id);

        if ($request->user()->id === $membership->user->id) {
            return redirect(
                \localized_route($membership->membershipable()->getRoutePrefix().'.show', $membership->membershipable())
            );
        }

        return redirect(
            \localized_route($membership->membershipable()->getRoutePrefix().'.edit', $membership->membershipable())
        );
    }
}
