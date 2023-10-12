<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\Textarea;

test('text area component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            Textarea::class,
            ['name' => 'bio', 'value' => '']
        );

    $view->assertSee('name="bio"', false);
    $view->assertSee('id="bio"', false);
});

test('text area component references hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            Textarea::class,
            ['name' => 'bio', 'hinted' => true, 'value' => '']
        );

    $view->assertSee('aria-describedby="bio-hint"', false);
});

test('text area component references supplied hint id', function () {
    $view = $this->withViewErrors([])
        ->component(
            Textarea::class,
            ['name' => 'bio', 'hinted' => 'my-hint', 'value' => '']
        );

    $view->assertSee('aria-describedby="my-hint"', false);
});

test('text area component handles validation error', function () {
    $view = $this->withViewErrors(['bio' => 'You must enter your bio.'])
        ->component(
            Textarea::class,
            ['name' => 'bio', 'value' => '']
        );

    $view->assertSee('aria-describedby="bio-error"', false);
    $view->assertSee('aria-invalid="true"', false);
});
