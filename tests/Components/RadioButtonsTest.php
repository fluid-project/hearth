<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\RadioButtons;

test('radio buttons component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButtons::class,
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
            ],
        );

    $view->assertSee('id="flavour-chocolate"', false);
    $view->assertSee('id="flavour-vanilla"', false);
});

test('radio buttons component references hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButtons::class,
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
                'hinted' => true,
            ],
        );

    $view->assertSee('aria-describedby="flavour-hint"', false);
});

test('radio buttons component references custom hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButtons::class,
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
                'hinted' => 'favourite-flavour-hint',
            ],
        );

    $view->assertSee('aria-describedby="favourite-flavour-hint"', false);
});

test('radio buttons reference individual hints', function () {
    $view = $this->withViewErrors([])
        ->component(
            RadioButtons::class,
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                        'hint' => 'Rich and delicate.',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                        'hint' => 'Decadent and delicious.',
                    ],
                ],
                'hinted' => 'favourite-flavour-hint',
            ],
        );

    $view->assertSee('aria-describedby="flavour-chocolate-hint favourite-flavour-hint"', false);
    $view->assertSee('aria-describedby="flavour-vanilla-hint favourite-flavour-hint"', false);
});

test('radio buttons component includes attribute', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-buttons :name="$name" :options="$options" x-model="flavour" />',
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
            ],
        );

    $view->assertSee('x-model="flavour"', false);
});

test('radio buttons component includes checked button', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-buttons :name="$name" :options="$options" checked="vanilla" />',
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
            ],
        );

    $view->assertSee('value="vanilla"  checked', false);
    $view->assertDontSee('value="chocolate"  checked', false);
});

test('radio buttons component includes checked boolean button', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-buttons :name="$name" :options="$options" :checked="$checked" />',
            [
                'name' => 'email_me',
                'options' => [
                    [
                        'value' => '1',
                        'label' => 'Yes',
                    ],
                    [
                        'value' => '0',
                        'label' => 'No',
                    ],
                ],
                'checked' => 1,
            ],
        );

    $view->assertSee('value="1"  checked', false);
    $view->assertDontSee('value="0"  checked', false);
});

test('radio buttons component component has valid ids', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-buttons :name="$name" :options="$options" />',
            [
                'name' => 'flavour',
                'options' => [
                    [
                        'value' => 'French vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
            ],
        );

    $view->assertSee('id="flavour-french-vanilla"', false);

    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-radio-buttons :name="$name" :options="$options" />',
            [
                'name' => 'courses[dessert][ice-cream][flavour]',
                'options' => [
                    [
                        'value' => 'French vanilla',
                        'label' => 'Vanilla',
                    ],
                    [
                        'value' => 'chocolate',
                        'label' => 'Chocolate',
                    ],
                ],
            ],
        );

    $view->assertSee('id="coursesdessertice-creamflavour-french-vanilla"', false);
});
