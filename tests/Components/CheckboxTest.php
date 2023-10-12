<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\Checkbox;

test('checkbox component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkbox::class,
            [
                'name' => 'remember',
            ],
        );

    $view->assertSee('id="remember"', false);
});

test('checkbox component references hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkbox::class,
            [
                'name' => 'remember',
                'hinted' => true,
            ],
        );

    $view->assertSee('aria-describedby="remember-hint"', false);
});

test('checkbox component references custom hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkbox::class,
            [
                'name' => 'remember',
                'hinted' => 'remember-login-hint',
            ],
        );

    $view->assertSee('aria-describedby="remember-login-hint"', false);
});

test('checkbox component includes attribute', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-checkbox :name="$name" x-model="remember" />',
            [
                'name' => 'remember',
            ],
        );

    $view->assertSee('x-model="remember"', false);
});

test('checkbox component can be checked', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-checkbox :name="$name" :checked="true" />',
            [
                'name' => 'remember',
            ],
        );

    $view->assertSee('checked', false);
});
