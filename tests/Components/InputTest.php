<?php

namespace Hearth\Tests\Components;

use Hearth\Tests\TestCase;

class InputTest extends TestCase
{
    public function test_input_component_renders()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-input :name="$name" />',
                ['name' => 'fname']
            );

        $view->assertSee('name="fname"', false);
        $view->assertSee('id="fname"', false);
    }

    public function test_input_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-input :name="$name" hinted />',
                ['name' => 'fname']
            );

        $view->assertSee('aria-describedby="fname-hint"', false);
    }

    public function test_input_component_handles_validation_error()
    {
        $view = $this->withViewErrors(['fname' => 'You must enter your full name.'])
            ->blade(
                '<x-hearth-input :name="$name" />',
                ['name' => 'fname']
            );

        $view->assertSee('aria-describedby="fname-error"', false);
        $view->assertSee('aria-invalid="true"', false);
    }
}
