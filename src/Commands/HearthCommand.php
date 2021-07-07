<?php

namespace Hearth\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
            "\Illuminate\Session\Middleware\AuthenticateSession::class,
            \ChinLeung\MultilingualRoutes\DetectRequestLocale::class,",
            app_path('Http/Kernel.php')
        );

        // RedirectToPreferredLocale Middleware...
        $this->replaceInFile(
            "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,",
            "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'localize' => \App\Http\Middleware\RedirectToPreferredLocale::class,",
            app_path('Http/Kernel.php')
        );

        (new Filesystem())->ensureDirectoryExists(app_path('Actions/Fortify'));

        copy(
            __DIR__ . '/../../stubs/app/Actions/Fortify/CreateNewUser.php',
            app_path('Actions/Fortify/CreateNewUser.php')
        );
        copy(
            __DIR__ . '/../../stubs/app/Actions/Fortify/PasswordValidationRules.php',
            app_path('Actions/Fortify/PasswordValidationRules.php')
        );
        copy(
            __DIR__ . '/../../stubs/app/Actions/Fortify/UpdateUserPassword.php',
            app_path('Actions/Fortify/UpdateUserPassword.php')
        );
        copy(
            __DIR__ . '/../../stubs/app/Actions/Fortify/UpdateUserProfileInformation.php',
            app_path('Actions/Fortify/UpdateUserProfileInformation.php')
        );

        copy(__DIR__ . '/../../stubs/app/Models/User.php', app_path('Models/User.php'));

        copy(
            __DIR__ . '/../../stubs/app/Http/Middleware/RedirectToPreferredLocale.php',
            app_path('Http/Middleware/RedirectToPreferredLocale.php')
        );

        copy(
            __DIR__ . '/../../stubs/routes/fortify.php',
            base_path('routes/fortify.php')
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
