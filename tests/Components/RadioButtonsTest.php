<?php

namespace Hearth\Tests\Components;

use Hearth\Components\RadioButtons;
use Hearth\Tests\TestCase;

class RadioButtonsTest extends TestCase
{
    public function test_radio_buttons_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                RadioButtons::class,
                [
                    'name' => 'flavour',
                    'label' => 'Favourite flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                ],
            );

        $view->assertSee('id="flavour-chocolate"', false);
        $view->assertSee('id="flavour-vanilla"', false);
    }

    public function test_radio_buttons_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                RadioButtons::class,
                [
                    'name' => 'flavour',
                    'label' => 'Favourite flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                    'hinted' => true,
                ],
            );

        $view->assertSee('aria-describedby="flavour-hint"', false);
    }

    public function test_radio_buttons_component_references_custom_hint()
    {
        $view = $this->withViewErrors(['birthday' => 'You entered a date that does not exist!'])
            ->component(
                RadioButtons::class,
                [
                    'name' => 'flavour',
                    'label' => 'Favourite flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                    'hinted' => 'favourite-flavour-hint',
                ],
            );

        $view->assertSee('aria-describedby="favourite-flavour-hint"', false);
    }

    public function test_radio_buttons_component_includes_attribute()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-radio-buttons :name="$name" :label="$label" :options="$options" x-model="flavour" />',
                [
                    'name' => 'flavour',
                    'label' => 'Favourite flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                ],
            );

        $view->assertSee('x-model="flavour"', false);
    }
}
