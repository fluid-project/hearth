<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\RadioButton;

test('radio button component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButton::class,
            [
                'name' => 'flavour',
                'value' => 'vanilla',
            ],
        );

    $view->assertSee('id="flavour-vanilla"', false);
});

test('radio button component references hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButton::class,
            [
                'name' => 'flavour',
                'value' => 'vanilla',
                'hinted' => true,
            ],
        );

    $view->assertSee('aria-describedby="flavour-hint"', false);
});

test('radio button component references custom hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButton::class,
            [
                'name' => 'flavour',
                'value' => 'vanilla',
                'hinted' => 'flavour-vanilla-hint',
            ],
        );

    $view->assertSee('aria-describedby="flavour-vanilla-hint"', false);
});

test('radio button component includes attribute', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-button :name="$name" :value="$value" x-model="flavour" />',
            [
                'name' => 'flavour',
                'value' => 'vanilla',
            ],
        );

    $view->assertSee('x-model="flavour"', false);
});

test('radio button component can be checked', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-button :name="$name" :value="$value" :checked="true" />',
            [
                'name' => 'flavour',
                'value' => 'vanilla',
            ],
        );

    $view->assertSee('checked', false);
});
