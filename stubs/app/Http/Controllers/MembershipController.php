<?php

namespace App\Http\Controllers;

use App\Actions\DestroyMembership;
use App\Http\Requests\UpdateMembershipRequest;
use Hearth\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MembershipController extends Controller
{
    /**
     * Show the form for editing the specified membershipable member.
     *
     * @param  Membership  $membership
     * @return mixed
     */
    public function edit(Membership $membership)
    {
        $roles = [];

        foreach (config('hearth.organizations.roles') as $role) {
            $roles[$role] = __('roles.' . $role);
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
     *
     * @param UpdateMembershipRequest $request
     * @param Membership $membership
     * @return RedirectResponse
     */
    public function update(UpdateMembershipRequest $request, Membership $membership): RedirectResponse
    {
        $validated = $request->validated();

        $membership->membershipable()->users()->updateExistingPivot($membership->user->id, [
            'role' => $validated['role'],
        ]);

        if ($request->user()->id === $membership->user->id && $request->input('role') !== 'admin') {
            return redirect(
                \localized_route($membership->membershipable()->getRoutePrefix() . '.show', $membership->membershipable())
            );
        }

        return redirect(
            \localized_route($membership->membershipable()->getRoutePrefix() . '.edit', $membership->membershipable())
        );
    }

    /**
     * Remove the given member from the organization.
     *
     * @param Request $request
     * @param Membership $membership
     * @return RedirectResponse
     */
    public function destroy(Request $request, Membership $membership): RedirectResponse
    {
        app(DestroyMembership::class)->destroy(
            $request->user(),
            $membership
        );

        if ($request->user()->id === $membership->user->id) {
            return redirect(
                \localized_route($membership->membershipable()->getRoutePrefix() . '.show', $membership->membershipable())
            );
        }

        return redirect(
            \localized_route($membership->membershipable()->getRoutePrefix() . '.edit', $membership->membershipable())
        );
    }
}
