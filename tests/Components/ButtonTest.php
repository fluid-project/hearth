<?php

namespace Hearth\Tests\Components;

use Hearth\Tests\TestCase;

class ButtonTest extends TestCase
{
    public function test_button_component_renders()
    {
        $view = $this->blade(
            '<x-hearth-button>Button</x-hearth-button>'
        );

        $view->assertSee('<button type="submit">Button</button>', false);
    }

    public function test_button_component_renders_with_different_type()
    {
        $view = $this->blade(
            '<x-hearth-button type="button">Button</x-hearth-button>'
        );

        $view->assertSee('<button type="button">Button</button>', false);
    }

    public function test_button_component_renders_with_class()
    {
        $view = $this->blade(
            '<x-hearth-button class="secondary">Button</x-hearth-button>'
        );

        $view->assertSee('<button type="submit" class="secondary">Button</button>', false);
    }
}
