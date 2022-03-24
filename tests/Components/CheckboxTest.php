<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Checkbox;
use Hearth\Tests\TestCase;

class CheckboxTest extends TestCase
{
    public function test_checkbox_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkbox::class,
                [
                    'name' => 'remember',
                ],
            );

        $view->assertSee('id="remember"', false);
    }

    public function test_checkbox_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkbox::class,
                [
                    'name' => 'remember',
                    'hinted' => true,
                ],
            );

        $view->assertSee('aria-describedby="remember-hint"', false);
    }

    public function test_checkbox_component_references_custom_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkbox::class,
                [
                    'name' => 'remember',
                    'hinted' => 'remember-login-hint',
                ],
            );

        $view->assertSee('aria-describedby="remember-login-hint"', false);
    }

    public function test_checkbox_component_includes_attribute()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkbox :name="$name" x-model="remember" />',
                [
                    'name' => 'remember',
                ],
            );

        $view->assertSee('x-model="remember"', false);
    }

    public function test_checkbox_component_can_be_checked()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkbox :name="$name" :checked="true" />',
                [
                    'name' => 'remember',
                ],
            );

        $view->assertSee('value="1" checked', false);
    }
}
