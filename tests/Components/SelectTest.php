<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\Select;

test('select component renders', function () {
    $view = $this->withViewErrors([])
        ->component(
            Select::class,
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

    $view->assertSee('<option value="chocolate"', false);
    $view->assertSee('<option value="vanilla"', false);
});

test('select component includes selected item', function () {
    $view = $this->withViewErrors([])
        ->blade(
            '<x-hearth-select :name="$name" :options="$options" selected="chocolate" />',
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

    $view->assertSee('<option value="chocolate" selected', false);
    $view->assertDontSee('<option value="vanilla" selected', false);
});
