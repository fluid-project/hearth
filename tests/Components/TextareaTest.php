<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Textarea;
use Hearth\Tests\TestCase;

class TextareaTest extends TestCase
{
    public function test_text_area_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                Textarea::class,
                ['name' => 'bio', 'value' => '']
            );

        $view->assertSee('name="bio"', false);
        $view->assertSee('id="bio"', false);
    }

    public function test_text_area_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Textarea::class,
                ['name' => 'bio', 'hinted' => true, 'value' => '']
            );

        $view->assertSee('aria-describedby="bio-hint"', false);
    }

    public function test_text_area_component_references_supplied_hint_id()
    {
        $view = $this->withViewErrors([])
            ->component(
                Textarea::class,
                ['name' => 'bio', 'hinted' => 'my-hint', 'value' => '']
            );

        $view->assertSee('aria-describedby="my-hint"', false);
    }

    public function test_text_area_component_handles_validation_error()
    {
        $view = $this->withViewErrors(['bio' => 'You must enter your bio.'])
            ->component(
                Textarea::class,
                ['name' => 'bio', 'value' => '']
            );

        $view->assertSee('aria-describedby="bio-error"', false);
        $view->assertSee('aria-invalid="true"', false);
    }
}
