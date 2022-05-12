<?php

namespace App\Http\Controllers;

use App\Actions\AcceptInvitation;
use App\Http\Requests\CreateInvitationRequest;
use App\Mail\Invitation as InvitationMessage;
use Hearth\Models\Invitation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /**
     * Create an invitation.
     *
     * @param  \App\Http\Requests\CreateInvitationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateInvitationRequest $request)
    {
        $validated = $request->validated();

        $invitationable = $request->input('invitationable_type')::where('id', $request->input('invitationable_id'))->first();

        $invitation = $invitationable->invitations()->create($validated);

        Mail::to($validated['email'])->send(new InvitationMessage($invitation));

        flash(__('invitation.create_invitation_succeeded'), 'success');

        return redirect(\localized_route($invitationable->getRoutePrefix() . '.edit', $invitationable));
    }

    /**
     * Accept the specified invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Hearth\Models\Invitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Request $request, Invitation $invitation)
    {
        app(AcceptInvitation::class)->accept(
            $invitation->invitationable,
            $invitation->email,
            $invitation->role
        );

        $invitation->delete();

        flash(
            __('invitation.accept_invitation_succeeded', ['invitationable' => $invitation->invitationable->name]),
            'success'
        );

        return redirect(\localized_route($invitation->invitationable->getRoutePrefix() . '.show', $invitation->invitationable));
    }

    /**
     * Cancel the specified invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Hearth\Models\Invitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Invitation $invitation)
    {
        if (! Gate::forUser($request->user())->check('update', $invitation->invitationable)) {
            throw new AuthorizationException();
        }

        $invitation->delete();

        flash(__('invitation.cancel_invitation_succeeded'), 'success');

        return redirect(\localized_route($invitation->invitationable->getRoutePrefix() . '.edit', $invitation->invitationable));
    }
}
