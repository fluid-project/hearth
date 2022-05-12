<?php

namespace App\Actions;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AcceptInvitation
{
    /**
     * Add a new organization member to the given organization.
     *
     * @param  mixed  $invitationable
     * @param  string  $email
     * @param  string|null  $role
     * @return void
     */
    public function accept($invitationable, string $email, string $role = null)
    {
        $this->validate($invitationable, $email, $role);

        $newMember = User::where('email', $email)->first();

        $invitationable->users()->attach(
            $newMember,
            ['role' => $role]
        );
    }

    /**
     * Validate the add member operation.
     *
     * @param  mixed  $invitationable
     * @param  string  $email
     * @param  string|null  $role
     * @return void|\Illuminate\Http\RedirectResponse
     */
    protected function validate($invitationable, string $email, ?string $role)
    {
        Validator::make(
            [
                "email" => $email,
                "role" => $role,
            ],
            $this->rules()
        )
            ->after($this->ensureInviteeIsNotAlreadyAMember($invitationable, $email))
            ->after($this->ensureCurrentUserIsInvitee(Auth::user(), $email))
            ->validateWithBag("acceptInvitation");
    }

    /**
     * Get the validation rules for adding a organization member.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'email' => ['required', 'email'],
            'role' => ['required', 'string', Rule::in(config('hearth.organizations.roles'))],
        ];
    }

    /**
     * Ensure that the user is not already on the organization.
     *
     * @param  mixed  $invitationable
     * @param  string  $email
     * @return \Closure
     */
    protected function ensureInviteeIsNotAlreadyAMember($invitationable, string $email): \Closure
    {
        return function ($validator) use ($invitationable, $email) {
            $validator->errors()->addIf(
                $invitationable->hasUserWithEmail($email),
                'email',
                __('invitation.invited_user_already_belongs_to_team')
            );
        };
    }

    /**
     * Ensure that the authenticated user is the user who was invited.
     *
     * @param  \App\Models\User  $user
     * @param  string  $email
     * @return \Closure
     */
    protected function ensureCurrentUserIsInvitee(User $user, string $email): \Closure
    {
        return function ($validator) use ($user, $email) {
            if ($user->email !== $email) {
                $validator->errors()->add(
                    'email',
                    __('invitation.email_not_valid', ['email' => $user->email])
                );
            }
        };
    }
}
