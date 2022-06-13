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
        $view = $this->withViewErrors([])
            ->component(
                RadioButtons::class,
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

    public function test_radio_buttons_reference_individual_hints()
    {
        $view = $this->withViewErrors([])
            ->component(
                RadioButtons::class,
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => [
                            'label' => 'Vanilla',
                            'hint' => 'Rich and delicate.',
                        ],
                        'chocolate' => [
                            'label' => 'Chocolate',
                            'hint' => 'Decadent and delicious.',
                        ],
                    ],
                    'hinted' => 'favourite-flavour-hint',
                ],
            );

        $view->assertSee('aria-describedby="flavour-chocolate-hint favourite-flavour-hint"', false);
        $view->assertSee('aria-describedby="flavour-vanilla-hint favourite-flavour-hint"', false);
    }

    public function test_radio_buttons_component_includes_attribute()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-radio-buttons :name="$name" :options="$options" x-model="flavour" />',
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                ],
            );

        $view->assertSee('x-model="flavour"', false);
    }

    public function test_radio_buttons_component_includes_checked_button()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-radio-buttons :name="$name" :options="$options" checked="vanilla" />',
                [
                    'name' => 'flavour',
                    'options' => [
                        'vanilla' => 'Vanilla',
                        'chocolate' => 'Chocolate',
                    ],
                ],
            );

        $view->assertSee('value="vanilla"  checked', false);
        $view->assertDontSee('value="chocolate"  checked', false);
    }

    public function test_radio_buttons_component_includes_checked_boolean_button()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-radio-buttons :name="$name" :options="$options" :checked="$checked" />',
                [
                    'name' => 'email_me',
                    'options' => [
                        '1' => 'Yes',
                        '0' => 'No',
                    ],
                    'checked' => 1
                ],
            );

        $view->assertSee('value="1"  checked', false);
        $view->assertDontSee('value="0"  checked', false);
    }
}
