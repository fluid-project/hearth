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
        $this->callSilent('vendor:publish', ['--provider' => 'Hearth\HearthServiceProvider', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
        $this->callSilent('vendor:publish', [
            '--provider' => 'ChinLeung\LaravelLocales\LaravelLocalesServiceProvider',
            '--tag' => 'config',
        ]);

        // AuthenticateSession Middleware...
        $this->replaceInFile(
            '// \Illuminate\Session\Middleware\AuthenticateSession::class,',
            "\Illuminate\Session\Middleware\AuthenticateSession::class,",
            app_path('Http/Kernel.php')
        );

        // DetectRequestLocale Middleware...
        $this->replaceInFile(
            '\App\Http\Middleware\VerifyCsrfToken::class,',
            "\App\Http\Middleware\VerifyCsrfToken::class,
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
        (new Filesystem())->ensureDirectoryExists(app_path('Policies'));
        (new Filesystem())->ensureDirectoryExists(app_path('Requests'));
        (new Filesystem())->ensureDirectoryExists(app_path('Requests/Auth'));
        (new Filesystem())->ensureDirectoryExists(app_path('Responses'));
        (new Filesystem())->ensureDirectoryExists(app_path('Rules'));

        // App stubs...
        $app_stubs = [
            'Actions/Fortify/CreateNewUser.php',
            'Actions/Fortify/PasswordValidationRules.php',
            'Actions/Fortify/UpdateUserPassword.php',
            'Actions/Fortify/UpdateUserProfileInformation.php',
            'Http/Controllers/UserController.php',
            'Http/Controllers/VerifyEmailController.php',
            'Http/Middleware/Authenticate.php',
            'Http/Middleware/RedirectIfAuthenticated.php',
            'Http/Middleware/RedirectToPreferredLocale.php',
            'Models/User.php',
            'Policies/UserPolicy.php',
            'Requests/Auth/LoginRequest.php',
            'Requests/DestroyUserRequest.php',
            'Responses/LoginResponse.php',
            'Responses/PasswordResetResponse.php',
            'Responses/RegisterResponse.php',
            'Responses/TwoFactorLoginResponse.php',
            'Rules/Password.php',
        ];

        foreach ($app_stubs as $path) {
            copy(__DIR__ . "/../../stubs/app/{$path}", app_path($path));
        }

        // Config stubs...
        $config_stubs = [
            'fortify.php',
            'laravel-multilingual-routes.php',
            'locales.php',
        ];

        foreach ($config_stubs as $config) {
            copy(__DIR__ . "/../../stubs/config/{$config}", base_path("config/{$config}"));
        }

        // Route stubs...
        $route_stubs = [
            'fortify.php',
        ];

        foreach ($route_stubs as $route) {
            copy(__DIR__ . "/../../stubs/routes/{$route}", base_path("routes/{$route}"));
        }
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
