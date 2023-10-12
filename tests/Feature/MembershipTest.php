<?php

use App\Models\Organization;
use App\Models\User;
use Hearth\Models\Membership;

test('membership can be created for organization', function () {
    $user = User::forceCreate([
        'name' => 'Frodo Baggins',
        'email' => 'frodo@bag-end.net',
        'password' => 'secret',
    ]);

    $organization = Organization::forceCreate([
        'name' => json_encode(['en' => 'Fellowship']),
        'locality' => 'Rivendell',
        'region' => 'BC',
    ]);

    $organization->users()->attach($user, ['role' => 'admin']);

    $membership = Membership::where('id', $organization->users->first()->membership->id)->first();

    expect($organization->users)->toHaveCount(1);
    expect($organization->administrators)->toHaveCount(1);
    expect($organization->hasUserWithEmail($user->email))->toBeTrue();
    expect($organization->hasAdministratorWithEmail($user->email))->toBeTrue();
    expect(get_class($organization))->toEqual($membership->membershipable_type);
    expect($organization->id)->toEqual($membership->membershipable_id);
    expect($membership->membershipable()->id)->toEqual($organization->id);
    expect($membership->user->id)->toEqual($user->id);
});
