<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get(localized_route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(localized_route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'locale' => 'en',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(localized_route('dashboard'));
});
