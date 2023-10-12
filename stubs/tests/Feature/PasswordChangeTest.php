<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('password can be updated', function () {
    $user = User::factory()->create();

    $response = $this->from(localized_route('users.admin'))->actingAs($user)->put(localized_route('user-password.update'), [
        'current_password' => 'password',
        'password' => 'new_password',
        'password_confirmation' => 'new_password',
    ]);

    $response->assertRedirect(localized_route('users.admin'));
});

test('password cannot be updated with incorrect current password', function () {
    $user = User::factory()->create();

    $response = $this->from(localized_route('users.admin'))->actingAs($user)->put(localized_route('user-password.update'), [
        'current_password' => 'wrong_password',
        'password' => 'new_password',
        'password_confirmation' => 'new_password',
    ]);

    $response->assertRedirect(localized_route('users.admin'));
});

test('password cannot be updated with password that do not match', function () {
    $user = User::factory()->create();

    $response = $this->from(localized_route('users.admin'))->actingAs($user)->put(localized_route('user-password.update'), [
        'current_password' => 'password',
        'password' => 'new_password',
        'password_confirmation' => 'different_new_password',
    ]);

    $response->assertRedirect(localized_route('users.admin'));
});
