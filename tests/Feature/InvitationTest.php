<?php

use App\Models\Organization;
use App\Models\User;
use Database\Factories\InvitationFactory;
use Hearth\Models\Invitation;

test('invitation factory', function () {
    expect(Invitation::factory())->toBeInstanceOf(InvitationFactory::class);
});

test('invitation can be created for organization', function () {
    $user = User::forceCreate([
        'name' => 'Frodo Baggins',
        'email' => 'frodo@bag-end.net',
        'password' => 'secret',
    ]);

    $otherUser = User::forceCreate([
        'name' => 'Samwise Gamgee',
        'email' => 'sam@bag-end.net',
        'password' => 'secret',
    ]);

    $organization = Organization::forceCreate([
        'name' => json_encode(['en' => 'Fellowship']),
        'locality' => 'Rivendell',
        'region' => 'BC',
    ]);

    $invitation = Invitation::forceCreate([
        'invitationable_id' => $organization->id,
        'invitationable_type' => get_class($organization),
        'email' => $user->email,
        'role' => 'admin',
    ]);

    $otherInvitation = Invitation::forceCreate([
        'invitationable_id' => $organization->id,
        'invitationable_type' => get_class($organization),
        'email' => $otherUser->email,
        'role' => 'member',
    ]);

    expect($organization->invitations)->toHaveCount(2);
    expect($invitation->invitationable->id)->toEqual($organization->id);

    $invitation->accept();
    $otherInvitation->accept();

    $organization = $organization->fresh();
    expect($organization->hasAdministratorWithEmail($user->email))->toBeTrue();
    expect($organization->hasUserWithEmail($otherUser->email))->toBeTrue();
});
