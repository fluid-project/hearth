<?php

use App\Models\Organization;
use App\Models\User;
use Hearth\Models\Invitation;
use Hearth\Models\Membership;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Spatie\Translatable\Exceptions\AttributeIsNotTranslatable;

uses(RefreshDatabase::class);

test('users can create organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.create'));
    $response->assertOk();

    $response = $this->actingAs($user)->post(localized_route('organizations.create'), [
        'name' => $user->name.' Consulting',
        'locality' => 'Truro',
        'region' => 'NS',
    ]);

    $organization = Organization::where('name->en', $user->name.' Consulting')->first();

    $url = localized_route('organizations.show', $organization);

    $response->assertSessionHasNoErrors();

    $response->assertRedirect($url);
});

test('users with admin role can edit organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.edit', $organization));
    $response->assertOk();

    $response = $this->actingAs($user)->put(localized_route('organizations.update', $organization), [
        'name' => $organization->name,
        'locality' => 'St John\'s',
        'region' => 'NL',
    ]);
    $response->assertRedirect(localized_route('organizations.show', $organization));
});

test('users without admin role can not edit organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'member'])
        ->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.edit', $organization));
    $response->assertForbidden();

    $response = $this->actingAs($user)->put(localized_route('organizations.update', $organization), [
        'name' => $organization->name,
        'locality' => 'St John\'s',
        'region' => 'NL',
    ]);
    $response->assertForbidden();
});

test('non members can not edit organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $other_organization = Organization::factory()
        ->hasAttached($other_user, ['role' => 'admin'])
        ->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.edit', $other_organization));
    $response->assertForbidden();

    $response = $this->actingAs($user)->put(localized_route('organizations.update', $other_organization), [
        'name' => $other_organization->name,
        'locality' => 'St John\'s',
        'region' => 'NL',
    ]);
    $response->assertForbidden();
});

test('organizations can be translated', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $organization = Organization::factory()->create();

    $organization->setTranslation('name', 'en', 'Name in English');
    $organization->setTranslation('name', 'fr', 'Name in French');

    expect($organization->name)->toEqual('Name in English');
    App::setLocale('fr');
    expect($organization->name)->toEqual('Name in French');

    expect($organization->getTranslation('name', 'en'))->toEqual('Name in English');
    expect($organization->getTranslation('name', 'fr'))->toEqual('Name in French');

    $translations = ['en' => 'Name in English', 'fr' => 'Name in French'];

    expect($organization->getTranslations('name'))->toEqual($translations);

    $this->expectException(AttributeIsNotTranslatable::class);
    $organization->setTranslation('locality', 'en', 'Locality in English');

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/en/organizations/name-in-english');
    $response->assertOk();

    $response = $this->actingAs($user)->get('/fr/organizations/name-in-french');
    $response->assertOk();
});

test('users with admin role can update other member roles', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->hasAttached($other_user, ['role' => 'member'])
        ->create();

    $membership = Membership::where('user_id', $other_user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('memberships.edit', $membership))
        ->put(localized_route('memberships.update', $membership), [
            'role' => 'admin',
        ]);
    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('users without admin role can not update member roles', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'member'])
        ->create();

    $membership = Membership::where('user_id', $user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('memberships.edit', $membership))
        ->put(localized_route('memberships.update', $membership), [
            'role' => 'admin',
        ]);

    $response->assertForbidden();
});

test('only administrator can not downgrade their role', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();
    $yet_another_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->hasAttached($other_user, ['role' => 'admin'])
        ->hasAttached($yet_another_user, ['role' => 'member'])
        ->create();

    $membership = Membership::where('user_id', $user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('memberships.edit', $membership))
        ->put(localized_route('memberships.update', $membership), [
            'role' => 'member',
        ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(localized_route('organizations.show', $organization));

    $membership = Membership::where('user_id', $other_user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($other_user)
        ->from(localized_route('memberships.edit', $membership))
        ->put(localized_route('memberships.update', $membership), [
            'role' => 'member',
        ]);

    $response->assertSessionHasErrors(['role']);
    $response->assertRedirect(localized_route('memberships.edit', $membership));
});

test('users with admin role can invite members', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->post(localized_route('invitations.create'), [
            'invitationable_id' => $organization->id,
            'invitationable_type' => get_class($organization),
            'email' => 'newuser@here.com',
            'role' => 'member',
        ]);

    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('users without admin role can not invite members', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'member'])
        ->create();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->post(localized_route('invitations.create'), [
            'invitationable_id' => $organization->id,
            'invitationable_type' => get_class($organization),
            'email' => 'newuser@here.com',
            'role' => 'member',
        ]);

    $response->assertForbidden();
});

test('users with admin role can cancel invitations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();
    $invitation = Invitation::factory()->create([
        'invitationable_id' => $organization->id,
        'invitationable_type' => get_class($organization),
        'email' => 'me@here.com',
    ]);

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->delete(route('invitations.destroy', ['invitation' => $invitation]));

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('users without admin role can not cancel invitations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'member'])
        ->create();
    $invitation = Invitation::factory()->create([
        'invitationable_id' => $organization->id,
        'invitationable_type' => get_class($organization),
        'email' => 'me@here.com',
    ]);

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->delete(route('invitations.destroy', ['invitation' => $invitation]));

    $response->assertForbidden();
});

test('existing members cannot be invited', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->hasAttached($other_user, ['role' => 'member'])
        ->create();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->post(localized_route('invitations.create'), [
            'invitationable_id' => $organization->id,
            'invitationable_type' => get_class($organization),
            'email' => $other_user->email,
            'role' => 'member',
        ]);

    $response->assertSessionHasErrorsIn('inviteMember', ['email']);
    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('invitation can be accepted', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $invitation = Invitation::factory()->create([
        'invitationable_id' => $organization->id,
        'invitationable_type' => get_class($organization),
        'email' => $user->email,
    ]);

    $acceptUrl = URL::signedRoute('invitations.accept', ['invitation' => $invitation]);

    $response = $this->actingAs($user)->get($acceptUrl);

    expect($organization->fresh()->hasUserWithEmail($user->email))->toBeTrue();
    $response->assertRedirect(localized_route('organizations.show', $organization));
});

test('invitation cannot be accepted by user with existing membership', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();
    $other_organization = Organization::factory()->create();
    $invitation = Invitation::factory()->create([
        'invitationable_id' => $other_organization->id,
        'invitationable_type' => get_class($other_organization),
        'email' => $user->email,
    ]);

    $acceptUrl = URL::signedRoute('invitations.accept', ['invitation' => $invitation]);

    $response = $this->from(localized_route('dashboard'))->actingAs($user)->get($acceptUrl);

    expect($other_organization->fresh()->hasUserWithEmail($user->email))->toBeFalse();
    $response->assertSessionHasErrors();
    $response->assertRedirect(localized_route('dashboard'));
});

test('invitation cannot be accepted by different user', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($other_user, ['role' => 'admin'])
        ->create();
    $invitation = Invitation::factory()->create([
        'invitationable_id' => $organization->id,
        'invitationable_type' => get_class($organization),
        'email' => $user->email,
    ]);

    $acceptUrl = URL::signedRoute('invitations.accept', ['invitation' => $invitation]);

    $response = $this->from(localized_route('dashboard'))->actingAs($other_user)->get($acceptUrl);

    expect($organization->fresh()->hasUserWithEmail($user->email))->toBeFalse();
    $response->assertSessionHasErrors();
    $response->assertRedirect(localized_route('dashboard'));
});

test('users with admin role can remove members', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->hasAttached($other_user, ['role' => 'member'])
        ->create();

    $membership = Membership::where('user_id', $other_user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->delete(route('memberships.destroy', $membership));

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('users without admin role can not remove members', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'member'])
        ->hasAttached($other_user, ['role' => 'admin'])
        ->create();

    $membership = Membership::where('user_id', $other_user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->delete(route('memberships.destroy', $membership));

    $response->assertForbidden();
});

test('only administrator can not remove themself', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $membership = Membership::where('user_id', $user->id)
        ->where('membershipable_type', 'App\Models\Organization')
        ->where('membershipable_id', $organization->id)
        ->first();

    $response = $this
        ->actingAs($user)
        ->from(localized_route('organizations.edit', ['organization' => $organization]))
        ->delete(route('memberships.destroy', $membership));

    $response->assertSessionHasErrors();
    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('users with admin role can delete organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->from(localized_route('organizations.edit', $organization))->delete(localized_route('organizations.destroy', $organization), [
        'current_password' => 'password',
    ]);

    $response->assertRedirect(localized_route('dashboard'));
});

test('users with admin role can not delete organizations with wrong password', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->from(localized_route('organizations.edit', $organization))->delete(localized_route('organizations.destroy', $organization), [
        'current_password' => 'wrong_password',
    ]);

    $response->assertSessionHasErrors();
    $response->assertRedirect(localized_route('organizations.edit', $organization));
});

test('users without admin role can not delete organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'member'])
        ->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->from(localized_route('organizations.edit', $organization))->delete(localized_route('organizations.destroy', $organization), [
        'current_password' => 'password',
    ]);

    $response->assertForbidden();
});

test('non members can not delete organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $other_user = User::factory()->create();

    $organization = Organization::factory()
        ->hasAttached($user, ['role' => 'admin'])
        ->create();

    $other_organization = Organization::factory()
        ->hasAttached($other_user, ['role' => 'admin'])
        ->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->from(localized_route('organizations.edit', $other_organization))->delete(localized_route('organizations.destroy', $other_organization), [
        'current_password' => 'password',
    ]);

    $response->assertForbidden();
});

test('users can view organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $user = User::factory()->create();
    $organization = Organization::factory()->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->get(localized_route('organizations.index'));
    $response->assertOk();

    $response = $this->get(localized_route('organizations.show', $organization));
    $response->assertOk();
});

test('guests can not view organizations', function () {
    if (! config('hearth.organizations.enabled')) {
        return $this->markTestSkipped('Organization support is not enabled.');
    }

    $organization = Organization::factory()->create();

    $response = $this->get(localized_route('organizations.index'));
    $response->assertRedirect(localized_route('login'));

    $response = $this->get(localized_route('organizations.show', $organization));
    $response->assertRedirect(localized_route('login'));
});
