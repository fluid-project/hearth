<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can request to join team', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.show', $organization));
    $response->assertSee('Request to join');

    $response = $this->actingAs($user)
        ->from(localized_route('organizations.show', $organization))
        ->post(localized_route('organizations.join', $organization));

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(localized_route('organizations.show', $organization));

    $organization = $organization->fresh();

    expect($organization->requestsToJoin->count())->toEqual(1);
    expect($organization->requestsToJoin->first()->id)->toEqual($user->id);
});

test('user with outstanding join request cannot request to join team', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $organization->requestsToJoin()->save($user);
    $otherOrganization = Organization::factory()->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.show', $otherOrganization));
    $response->assertDontSee('Request to join');

    $response = $this->actingAs($user)
        ->from(localized_route('organizations.show', $otherOrganization))
        ->post(localized_route('organizations.join', $otherOrganization));

    $response->assertForbidden();
});

test('user with existing membership cannot request to join team', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $organization->users()->attach($user, ['role' => 'admin']);
    $otherOrganization = Organization::factory()->create();

    $response = $this->actingAs($user)->get(localized_route('organizations.show', $otherOrganization));
    $response->assertDontSee('Request to join');

    $response = $this->actingAs($user)
        ->from(localized_route('organizations.show', $otherOrganization))
        ->post(localized_route('organizations.join', $otherOrganization));

    $response->assertForbidden();
});

test('user can cancel request to join team', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $organization->requestsToJoin()->save($user);

    $response = $this->actingAs($user)->get(localized_route('organizations.show', $organization));
    $response->assertSee('Cancel request');

    $response = $this->actingAs($user)->post(localized_route('requests.cancel'));
    $response->assertRedirect(localized_route('organizations.show', $organization));

    $user = $user->fresh();
    $organization = $organization->fresh();

    expect($user->joinable)->toBeNull();
    expect($organization->requestsToJoin->count())->toEqual(0);
});

test('admin can approve request to join team', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create();
    $organization = Organization::factory()->hasAttached($admin, ['role' => 'admin'])->create();
    $organization->requestsToJoin()->save($user);

    $response = $this->actingAs($admin)->get(localized_route('organizations.edit', $organization));
    $response->assertSee('Approve '.$user->name.'’s request');

    $response = $this->actingAs($admin)->post(localized_route('requests.approve', $user));

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(localized_route('organizations.edit', $organization));

    $user = $user->fresh();
    $organization = $organization->fresh();

    expect($user->joinable)->toBeNull();
    expect($organization->hasUserWithEmail($user->email))->toBeTrue();
});

test('admin can deny request to join team', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create();
    $organization = Organization::factory()->hasAttached($admin, ['role' => 'admin'])->create();
    $organization->requestsToJoin()->save($user);

    $response = $this->actingAs($admin)->get(localized_route('organizations.edit', $organization));
    $response->assertSee('Deny '.$user->name.'’s request');

    $response = $this->actingAs($admin)->post(localized_route('requests.deny', $user));

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(localized_route('organizations.edit', $organization));

    $user = $user->fresh();
    $organization = $organization->fresh();

    expect($user->joinable)->toBeNull();
    expect($organization->hasUserWithEmail($user->email))->toBeFalse();
});
