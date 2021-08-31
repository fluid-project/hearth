<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Input;
use Hearth\Tests\TestCase;

class InputTest extends TestCase
{
    public function test_input_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                Input::class,
                ['name' => 'fname']
            );

        $view->assertSee('name="fname"', false);
        $view->assertSee('id="fname"', false);
    }

    public function test_input_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Input::class,
                ['name' => 'fname', 'hinted' => true]
            );

        $view->assertSee('aria-describedby="fname-hint"', false);
    }

    public function test_input_component_references_supplied_hint_id()
    {
        $view = $this->withViewErrors([])
            ->component(
                Input::class,
                ['name' => 'fname', 'hinted' => 'my-hint']
            );

        $view->assertSee('aria-describedby="my-hint"', false);
    }

    public function test_input_component_handles_validation_error()
    {
        $view = $this->withViewErrors(['fname' => 'You must enter your full name.'])
            ->component(
                Input::class,
                ['name' => 'fname']
            );

        $view->assertSee('aria-describedby="fname-error"', false);
        $view->assertSee('aria-invalid="true"', false);
    }
}
