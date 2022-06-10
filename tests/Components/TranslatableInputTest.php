<?php

namespace Hearth\Tests\Components;

use Hearth\Components\TranslatableInput;
use Hearth\Tests\TestCase;

class TranslatableInputTest extends TestCase
{
    public function test_translatable_input_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                TranslatableInput::class,
                [
                    'name' => 'resource',
                    'label' => 'test resource',
                    'locales' => ['en', 'fr'],
                    'model' => null,
                ],
            );

        $view->assertSee('for="resource_en"', false);
        $view->assertSee('name="resource[en]"', false);
        $view->assertSee('id="resource_en"', false);
        $view->assertSee('id="test-resource-french"', false);
    }
}
