<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class JoinController extends Controller
{
    /**
     * Cancel a request to join a team.
     */
    public function cancel(Request $request): RedirectResponse
    {
        /** @var Organization */
        $joinable = $request->user()->joinable;

        dump($joinable->getTranslation('name', 'en'));

        flash(__('You have cancelled your request to join :team.', ['team' => $joinable->getTranslation('name', 'en')]), 'success');

        $request->user()->forceFill([
            'joinable_type' => null,
            'joinable_id' => null,
        ])->save();

        return redirect(\localized_route($joinable->getRoutePrefix().'.show', $joinable));
    }

    /**
     * Approve a request to join a team.
     */
    public function approve(Request $request, User $user): RedirectResponse
    {
        /** @var Organization */
        $joinable = $user->joinable;

        Gate::forUser($request->user())->authorize('update', $joinable);

        $user->forceFill([
            'joinable_type' => null,
            'joinable_id' => null,
        ])->save();

        $joinable->users()->attach($user);

        flash(__('You have approved :name’s request to join :team and they are now a member.', ['name' => $user->name, 'team' => $joinable->name]), 'success');

        return redirect(\localized_route($joinable->getRoutePrefix().'.edit', $joinable));
    }

    /**
     * Deny a request to join a team.
     */
    public function deny(Request $request, User $user): RedirectResponse
    {
        /** @var Organization */
        $joinable = $user->joinable;

        Gate::forUser($request->user())->authorize('update', $joinable);

        $user->forceFill([
            'joinable_type' => null,
            'joinable_id' => null,
        ])->save();

        flash(__('You have denied :name’s request to join :team.', ['name' => $user->name, 'team' => $joinable->name]), 'success');

        return redirect(\localized_route($joinable->getRoutePrefix().'.edit', $joinable));
    }
}
