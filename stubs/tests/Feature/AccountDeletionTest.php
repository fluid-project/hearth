<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('users can delete their own accounts', function () {
    $user = User::factory()->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();

    $response = $this->from(localized_route('users.admin'))->delete(localized_route('users.destroy'), [
        'current_password' => 'password',
    ]);

    $this->assertGuest();

    $response->assertRedirect(localized_route('welcome'));
});

test('users cannot delete their own accounts with incorrect password', function () {
    $user = User::factory()->create();

    $response = $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();

    $response = $this->from(localized_route('users.admin'))->delete(localized_route('users.destroy'), [
        'current_password' => 'wrong_password',
    ]);

    $response->assertRedirect(localized_route('users.admin'));
});

test('guests cannot delete accounts', function () {
    $user = User::factory()->create();

    $response = $this->delete(localized_route('users.destroy'));

    $response->assertRedirect(localized_route('login'));
});
