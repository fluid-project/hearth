<?php

namespace Hearth\Tests\Components;

use Hearth\Components\RadioButton;
use Hearth\Tests\TestCase;

class RadioButtonTest extends TestCase
{
    public function test_radio_button_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                RadioButton::class,
                [
                    'name' => 'flavour',
                    'value' => 'vanilla',
                ],
            );

        $view->assertSee('id="flavour-vanilla"', false);
    }

    public function test_radio_button_component_references_hint()
    {
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
    }

    public function test_radio_button_component_references_custom_hint()
    {
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
    }

    public function test_radio_button_component_includes_attribute()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-radio-button :name="$name" :value="$value" x-model="flavour" />',
                [
                    'name' => 'flavour',
                    'value' => 'vanilla',
                ],
            );

        $view->assertSee('x-model="flavour"', false);
    }

    public function test_radio_button_component_can_be_checked()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-radio-button :name="$name" :value="$value" :checked="true" />',
                [
                    'name' => 'flavour',
                    'value' => 'vanilla',
                ],
            );

        $view->assertSee('checked', false);
    }
}
