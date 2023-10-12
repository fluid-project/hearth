<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get(localized_route('login'));

    $response->assertOk();
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(localized_route('dashboard'));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can edit own profiles', function () {
    $user = User::factory()->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->get(localized_route('users.edit'));
    $response->assertOk();
});

test('guests can not edit profiles', function () {
    $response = $this->get(localized_route('users.edit'));
    $response->assertRedirect(localized_route('login'));
});
