<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use PragmaRX\Google2FA\Google2FA;

uses(RefreshDatabase::class);

test('users must confirm password before enabling two factor authentication', function () {
    if (! Features::enabled(Features::twoFactorAuthentication())) {
        return $this->markTestSkipped('Two-factor authentication support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $response = $this->post(route('two-factor.enable'));

    $response->assertRedirect(localized_route('password.confirm'));

    expect($user->twoFactorAuthEnabled())->toBeFalse();
});

test('users who have confirmed password can enable two factor authentication', function () {
    if (! Features::enabled(Features::twoFactorAuthentication())) {
        return $this->markTestSkipped('Two-factor authentication support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(route('two-factor.enable'));

    expect($user->twoFactorAuthEnabled())->toBeTrue();
});

test('users can authenticate with two factor code', function () {
    if (! Features::enabled(Features::twoFactorAuthentication())) {
        return $this->markTestSkipped('Two-factor authentication support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(route('two-factor.enable'));

    $this->post(localized_route('logout'));

    $this->assertGuest();

    $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->post(localized_route('two-factor.login'), [
        'code' => (new Google2FA())->getCurrentOtp(decrypt($user->two_factor_secret)),
    ]);

    $response->assertRedirect(localized_route('dashboard'));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid two factor code', function () {
    if (! Features::enabled(Features::twoFactorAuthentication())) {
        return $this->markTestSkipped('Two-factor authentication support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(route('two-factor.enable'));

    $this->post(localized_route('logout'));

    $this->assertGuest();

    $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->post(localized_route('two-factor.login'), [
        'code' => '123456',
    ]);

    $response->assertRedirect(localized_route('login'));

    $this->assertGuest();
});

test('users can authenticate with recovery code', function () {
    if (! Features::enabled(Features::twoFactorAuthentication())) {
        return $this->markTestSkipped('Two-factor authentication support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(route('two-factor.enable'));

    $this->post(localized_route('logout'));

    $this->assertGuest();

    $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->post(localized_route('two-factor.login'), [
        'recovery_code' => $user->recoveryCodes()[0],
    ]);

    $response->assertRedirect(localized_route('dashboard'));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid recovery code', function () {
    if (! Features::enabled(Features::twoFactorAuthentication())) {
        return $this->markTestSkipped('Two-factor authentication support is not enabled.');
    }

    $this->actingAs($user = User::factory()->create());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $this->post(route('two-factor.enable'));

    $this->post(localized_route('logout'));

    $this->assertGuest();

    $this->post(localized_route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->post(localized_route('two-factor.login'), [
        'recovery_code' => 'fake recovery code',
    ]);

    $response->assertRedirect(localized_route('login'));

    $this->assertGuest();
});
