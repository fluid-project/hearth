<?php

namespace Hearth\Tests\Components;

use Hearth\Components\Checkboxes;
use Hearth\Tests\TestCase;

class CheckboxesTest extends TestCase
{
    public function test_checkboxes_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
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

        $view->assertSee('id="flavour-chocolate"', false);
        $view->assertSee('id="flavour-vanilla"', false);
    }

    public function test_checkboxes_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
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
                    'hinted' => true,
                ],
            );

        $view->assertSee('aria-describedby="flavour-hint"', false);
    }

    public function test_checkboxes_component_references_custom_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
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
                    'hinted' => 'favourite-flavour-hint',
                ],
            );

        $view->assertSee('aria-describedby="favourite-flavour-hint"', false);
    }

    public function test_checkboxes_reference_individual_hints()
    {
        $view = $this->withViewErrors([])
            ->component(
                Checkboxes::class,
                [
                    'name' => 'flavour',
                    'options' => [
                        [
                            'value' => 'vanilla',
                            'label' => 'Vanilla',
                            'hint' => 'Rich and delicate.',
                        ],
                        [
                            'value' => 'chocolate',
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

    public function test_checkboxes_component_includes_attribute()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkboxes :name="$name" :options="$options" x-model="flavours" />',
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

        $view->assertSee('x-model="flavours"', false);
    }

    public function test_checkboxes_component_includes_checked_item()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkboxes :name="$name" :options="$options" :checked="$checked" />',
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
                    'checked' => ['vanilla'],
                ],
            );

        $view->assertSee('value="vanilla"  checked', false);
        $view->assertDontSee('value="chocolate"  checked', false);
    }

    public function test_checkboxes_component_has_valid_ids()
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkboxes :name="$name" :options="$options" />',
                [
                    'name' => 'flavour',
                    'options' => [
                        [
                            'value' => 'French vanilla',
                            'label' => 'Vanilla',
                        ],
                        [
                            'value' => 'chocolate',
                            'label' => 'Chocolate',
                        ],
                    ],
                ],
            );

        $view->assertSee('id="flavour-french-vanilla"', false);

        $view = $this->withViewErrors([])
            ->blade(
                '<x-hearth-checkboxes :name="$name" :options="$options" />',
                [
                    'name' => 'courses[dessert][ice-cream][flavour]',
                    'options' => [
                        [
                            'value' => 'French vanilla',
                            'label' => 'Vanilla',
                        ],
                        [
                            'value' => 'chocolate',
                            'label' => 'Chocolate',
                        ],
                    ],
                ],
            );

        $view->assertSee('id="coursesdessertice-creamflavour-french-vanilla"', false);
    }

    public function test_checkboxes_component_handles_validation()
    {
        $view = $this->withViewErrors(['flavour.0.required' => 'Vanilla is a required flavour.'])
            ->blade(
                '<x-hearth-checkboxes :name="$name" :options="$options" />',
                [
                    'name' => 'flavour',
                    'options' => [
                        [
                            'value' => 'French vanilla',
                            'label' => 'Vanilla',
                        ],
                        [
                            'value' => 'chocolate',
                            'label' => 'Chocolate',
                        ],
                    ],
                ],
            );

        $view->assertSee('aria-invalid', false);
    }
}
