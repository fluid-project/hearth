<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Hint;
use Hearth\Tests\TestCase;

class HintTest extends TestCase
{
    public function test_hint_component_renders()
    {
        $view = $this->blade('<x-hearth-hint for="fname">Enter your given name.</x-hearth-hint>');

        $view->assertSee('id="fname-hint"', false);
        $view->assertSee('<p>Enter your given name.</p>', false);
    }

    public function test_hint_component_renders_markdown()
    {
        $view = $this->blade('<x-hearth-hint for="fname">Enter a valid [DOI](https://www.doi.org).</x-hearth-hint>');

        $view->assertSee('<p>Enter a valid <a href="https://www.doi.org">DOI</a>.</p>', false);
    }
}
