<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Checkboxes;
use Hearth\Tests\TestCase;

class CheckboxesTest extends TestCase
{
    public function test_checkboxes_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                ],
            );

        $view->assertSee('id="flavour-chocolate"', false);
        $view->assertSee('id="flavour-vanilla"', false);
    }

    public function test_checkboxes_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                    'hinted' => true,
                ],
            );

        $view->assertSee('aria-describedby="flavour-hint"', false);
    }

    public function test_checkboxes_component_references_custom_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                    'hinted' => 'favourite-flavour-hint',
                ],
            );

        $view->assertSee('aria-describedby="favourite-flavour-hint"', false);
    }

    public function test_checkboxes_component_includes_attribute()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkboxes :name="$name" :options="$options" x-model="flavours" />',
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                ],
            );

        $view->assertSee('x-model="flavours"', false);
    }
}
