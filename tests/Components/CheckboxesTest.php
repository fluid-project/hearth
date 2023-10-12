<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\Checkboxes;

test('checkboxes component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkboxes::class,
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

test('checkboxes component references hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkboxes::class,
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

test('checkboxes component references custom hint', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkboxes::class,
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

test('checkboxes reference individual hints', function () {
    $view = $this->withViewErrors([])
        ->component(
            Checkboxes::class,
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

test('checkboxes component includes attribute', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-checkboxes :name="$name" :options="$options" x-model="flavours" />',
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

    $view->assertSee('x-model="flavours"', false);
});

test('checkboxes component includes checked item', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-checkboxes :name="$name" :options="$options" :checked="$checked" />',
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
                'checked' => ['vanilla'],
            ],
        );

    $view->assertSee('value="vanilla"  checked', false);
    $view->assertDontSee('value="chocolate"  checked', false);
});

test('checkboxes component has valid ids', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-checkboxes :name="$name" :options="$options" />',
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
            '<x-hearth-checkboxes :name="$name" :options="$options" />',
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

test('checkboxes component handles validation', function () {
    $view = $this->withViewErrors(['flavour.0.required' => 'Vanilla is a required flavour.'])
        ->blade(
            '<x-hearth-checkboxes :name="$name" :options="$options" />',
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

    $view->assertSee('aria-invalid', false);
});
