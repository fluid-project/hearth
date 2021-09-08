<?php

namespace Hearth\Tests;

class ConsoleTest extends TestCase
{
    public function test_install_command()
    {
        $this->artisan('hearth:install')
            ->expectsConfirmation('Do you want to add support for an additional locale?', 'yes')
            ->expectsQuestion('Choose a locale', 'Welsh')
            ->expectsOutput('Welsh added to locales!')
            ->expectsConfirmation('Do you want to add support for an additional locale?', 'no')
            ->assertExitCode(0);
    }
}
