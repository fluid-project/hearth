<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\Input;

test('input component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            Input::class,
            ['name' => 'fname']
        );

    $view->assertSee('name="fname"', false);
    $view->assertSee('id="fname"', false);
});

test('input component references hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            Input::class,
            ['name' => 'fname', 'hinted' => true]
        );

    $view->assertSee('aria-describedby="fname-hint"', false);
});

test('input component references supplied hint id', function () {
    $view = $this->withViewErrors([])
        ->component(
            Input::class,
            ['name' => 'fname', 'hinted' => 'my-hint']
        );

    $view->assertSee('aria-describedby="my-hint"', false);
});

test('input component handles validation error', function () {
    $view = $this->withViewErrors(['fname' => 'You must enter your full name.'])
        ->component(
            Input::class,
            ['name' => 'fname']
        );

    $view->assertSee('aria-describedby="fname-error"', false);
    $view->assertSee('aria-invalid="true"', false);
});

test('input component with array name handles validation error', function () {
    $view = $this->withViewErrors(['links.0.url' => 'You must enter a valid URL.'])
        ->component(
            Input::class,
            ['name' => 'links[0][url]']
        );

    $view->assertSee('aria-describedby="links_0_url-error"', false);
    $view->assertSee('aria-invalid="true"', false);
});
