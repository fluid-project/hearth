<?php

use App\Models\Organization;
use App\Models\User;

test('user can have join request for organization', function () {
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

    $organization->requestsToJoin()->save($user);

    expect($organization->requestsToJoin)->toHaveCount(1);
    expect($organization->requestsToJoin->first()->id)->toEqual($user->id);
});
