<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user is redirected to preferred locale on login', function () {
    $user = User::factory()->create(['locale' => 'fr']);

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(localized_route('dashboard', [], 'fr'));
});

test('user is redirected to preferred locale when editing profile', function () {
    $user = User::factory()->create(['locale' => 'fr']);

    $response = $this->withCookie('locale', 'fr')->actingAs($user)->from(localized_route('users.edit'))->put(localized_route('user-profile-information.update'), [
        'name' => $user->name,
        'email' => $user->email,
        'locale' => 'en',
    ]);
    $response->assertRedirect(localized_route('users.edit', [], 'en'));
});
