<?php

namespace Hearth\Commands;

use Illuminate\Console\Command;

class HearthCommand extends Command
{
    public $signature = 'hearth:install';

    public $description = 'Install Hearth.';

    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'Hearth\HearthServiceProvider', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
        $this->callSilent('vendor:publish', [
            '--provider' => 'ChinLeung\LaravelLocales\LaravelLocalesServiceProvider',
            '--tag' => 'config',
        ]);
        $this->callSilent('vendor:publish', [
            '--provider' => 'ChinLeung\MultilingualRoutes\MultilingualRoutesServiceProvider',
            '--tag' => 'config',
        ]);

        // AuthenticateSession Middleware...
        $this->replaceInFile(
            '// \Illuminate\Session\Middleware\AuthenticateSession::class,',
            <<<EOT
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \ChinLeung\MultilingualRoutes\DetectRequestLocale::class,
            EOT,
            app_path('Http/Kernel.php')
        );

        (new Filesystem())->ensureDirectoryExists(app_path('Actions/Fortify'));

        copy(__DIR__.'/../../stubs/app/Actions/Fortify/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/PasswordValidationRules.php', app_path('Actions/Fortify/PasswordValidationRules.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/ResetUserPassword.php', app_path('Actions/Fortify/ResetUserPassword.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/UpdateUserPassword.php', app_path('Actions/Fortify/UpdateUserPassword.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/UpdateUserProfileInformation.php', app_path('Actions/Fortify/UpdateUserProfileInformation.php'));

        copy(__DIR__.'/../../stubs/app/Models/User.php', app_path('Models/User.php'));
    }
}
