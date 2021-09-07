<?php

namespace Hearth\Tests\Components;

use Hearth\Components\DateInput;
use Hearth\Tests\TestCase;

class DateInputTest extends TestCase
{
    public function test_date_input_component_renders()
    {
        $view = $this->withViewErrors([])
            ->component(
                DateInput::class,
                ['name' => 'birthday', 'label' => 'Your birthday']
            );

        $view->assertSee('name="birthday_year"', false);
        $view->assertSee('id="birthday_year"', false);
        $view->assertSee('name="birthday_month"', false);
        $view->assertSee('id="birthday_month"', false);
        $view->assertSee('name="birthday_day"', false);
        $view->assertSee('id="birthday_day"', false);
    }

    public function test_date_input_component_references_hint()
    {
        $view = $this->withViewErrors([])
            ->component(
                DateInput::class,
                [
                    'name' => 'birthday',
                    'label' => 'Your birthday',
                    'hint' => 'If you add your birthday to your account, we\'ll send you a treat!',
                ]
            );

        $view->assertSee('aria-describedby="birthday-hint"', false);
    }

    public function test_date_input_component_handles_validation_error()
    {
        $view = $this->withViewErrors(['birthday' => 'You entered a date that does not exist!'])
            ->component(
                DateInput::class,
                [
                    'name' => 'birthday',
                    'label' => 'Your birthday',
                    'hint' => 'If you add your birthday to your account, we\'ll send you a treat!',
                ]
            );

        $view->assertSee('aria-describedby="birthday-hint birthday-error"', false);
        $view->assertSee('aria-invalid="true"', false);
    }
}
