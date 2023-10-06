<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UserProfileInformationController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(
        Request $request,
        UpdatesUserProfileInformation $updater
    ) {
        $updater->update($request->user(), $request->all());

        return $request->wantsJson()
                    ? new JsonResponse('', 200)
                    : redirect(localized_route('users.edit', [], $request->input('locale') ?? 'en'))->with('status', 'profile-information-updated');
    }
}
