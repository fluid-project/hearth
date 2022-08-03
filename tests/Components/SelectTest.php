<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Select;
use Hearth\Tests\TestCase;

class SelectTest extends TestCase
{
    public function test_select_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                Select::class,
                [
                    'name' => 'flavour',
                    'options' => [
                        [
                            'value' => 'vanilla',
                            'label' => 'Vanilla',
                        ],
                        [
                            'value' => 'chocolate',
                            'label' => 'Chocolate',
                        ],
                    ],
                ],
            );

        $view->assertSee('<option value="chocolate"', false);
        $view->assertSee('<option value="vanilla"', false);
    }

    public function test_select_component_includes_selected_item()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-select :name="$name" :options="$options" selected="chocolate" />',
                [
                    'name' => 'flavour',
                    'options' => [
                        [
                            'value' => 'vanilla',
                            'label' => 'Vanilla',
                        ],
                        [
                            'value' => 'chocolate',
                            'label' => 'Chocolate',
                        ],
                    ],
                ],
            );

        $view->assertSee('<option value="chocolate" selected', false);
        $view->assertDontSee('<option value="vanilla" selected', false);
    }
}
