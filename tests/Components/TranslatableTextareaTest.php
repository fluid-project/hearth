<?php

namespace Hearth\Tests\Components;

use Hearth\Components\TranslatableTextarea;
use Hearth\Tests\TestCase;

class TranslatableTextareaTest extends TestCase
{
    public function test_translatable_textarea_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                TranslatableTextarea::class,
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
