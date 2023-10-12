<?php

uses(\Hearth\Tests\TestCase::class);
use Hearth\Components\DateInput;

test('date input component renders', function () {
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
});

test('date input component references hint', function () {
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
});

test('date input component handles validation error', function () {
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
});
