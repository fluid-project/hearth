<?php

uses(\Hearth\Tests\TestCase::class);
test('install command', function () {
    $this->artisan('hearth:install')
        ->expectsConfirmation('Do you want to add support for an additional locale?', 'yes')
        ->expectsQuestion('Choose a locale', 'Welsh')
        ->expectsOutput('Welsh added to locales!')
        ->expectsConfirmation('Do you want to add support for an additional locale?', 'yes')
        ->expectsQuestion('Choose a locale', 'fa')
        ->expectsOutput('Persian added to locales!')
        ->expectsConfirmation('Do you want to add support for an additional locale?', 'yes')
        ->expectsQuestion('Choose a locale', 'Dwarvish')
        ->expectsOutput('You entered an invalid locale code. Please try again, or type "no" to proceed without adding more locales.')
        ->expectsConfirmation('Do you want to add support for an additional locale?', 'yes')
        ->expectsQuestion('Choose a locale', '')
        ->expectsOutput('You entered an invalid locale code. Please try again, or type "no" to proceed without adding more locales.')
        ->expectsConfirmation('Do you want to add support for an additional locale?', 'no')
        ->assertExitCode(0);
});
