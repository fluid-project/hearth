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
        // Publish vendor files...
        $this->callSilent('vendor:publish', ['--provider' => 'Hearth\HearthServiceProvider', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
        $this->callSilent('vendor:publish', [
            '--provider' => 'ChinLeung\LaravelLocales\LaravelLocalesServiceProvider',
            '--tag' => 'config',
        ]);

        // Name...
        $this->replaceInFile('APP_NAME=Laravel', 'APP_NAME=Hearth', base_path('.env'));
        $this->replaceInFile('APP_NAME=Laravel', 'APP_NAME=Hearth', base_path('.env.example'));


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

        // FortifyServiceProvider...
        $this->replaceInFile(
            'App\Providers\RouteServiceProvider::class,',
            "App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,",
            config_path('app.php')
        );

        // Ensure folders are in place...
        (new Filesystem())->ensureDirectoryExists(app_path('Actions/Fortify'));
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests/Auth'));
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Responses'));
        (new Filesystem())->ensureDirectoryExists(app_path('Policies'));
        (new Filesystem())->ensureDirectoryExists(app_path('Rules'));
        (new Filesystem())->ensureDirectoryExists(app_path('View/Components'));
        (new Filesystem())->ensureDirectoryExists(base_path('resources/views/auth'));
        (new Filesystem())->ensureDirectoryExists(base_path('resources/views/components'));
        (new Filesystem())->ensureDirectoryExists(base_path('resources/views/errors'));
        (new Filesystem())->ensureDirectoryExists(base_path('resources/views/layouts'));
        (new Filesystem())->ensureDirectoryExists(base_path('resources/views/partials'));
        (new Filesystem())->ensureDirectoryExists(base_path('resources/views/users'));

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
            'Http/Requests/Auth/LoginRequest.php',
            'Http/Requests/DestroyUserRequest.php',
            'Http/Responses/LoginResponse.php',
            'Http/Responses/PasswordResetResponse.php',
            'Http/Responses/RegisterResponse.php',
            'Http/Responses/TwoFactorLoginResponse.php',
            'Models/User.php',
            'Policies/UserPolicy.php',
            'Providers/FortifyServiceProvider.php',
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
            'web.php',
        ];

        foreach ($route_stubs as $route) {
            copy(__DIR__ . "/../../stubs/routes/{$route}", base_path("routes/{$route}"));
        }

        // Factories...
        $factories = [
            'UserFactory.php',
        ];

        foreach ($factories as $factory) {
            copy(__DIR__ . "/../../database/factories/{$factory}", base_path("database/factories/{$factory}"));
        }

        // Views...
        $views = [
            'auth/confirm-password.blade.php',
            'auth/forgot-password.blade.php',
            'auth/login.blade.php',
            'auth/register.blade.php',
            'auth/reset-password.blade.php',
            'auth/verify-email.blade.php',
            'components/auth-card.blade.php',
            'components/auth-session-status.blade.php',
            'components/auth-validation-errors.blade.php',
            'components/brand.blade.php',
            'components/dropdown-link.blade.php',
            'components/dropdown.blade.php',
            'components/language-switcher.blade.php',
            'components/nav-link.blade.php',
            'components/navigation.blade.php',
            'components/validation-error.blade.php',
            'errors/401.blade.php',
            'errors/403.blade.php',
            'errors/404.blade.php',
            'errors/419.blade.php',
            'errors/429.blade.php',
            'errors/500.blade.php',
            'errors/503.blade.php',
            'errors/errorpage.blade.php',
            'layouts/app.blade.php',
            'layouts/banner.blade.php',
            'layouts/guest.blade.php',
            'partials/flash-messages.blade.php',
            'partials/head.blade.php',
            'partials/validation-errors.blade.php',
            'users/admin.blade.php',
            'users/edit.blade.php',
            'dashboard.blade.php',
            'welcome.blade.php',
        ];

        foreach ($views as $view) {
            copy(__DIR__ . "/../../stubs/resources/views/{$view}", base_path("resources/views/{$view}"));
        }

        // View components...
        $components = [
            'AppLayout.php',
            'GuestLayout.php',
            'LanguageSwitcher.php',
        ];

        foreach ($components as $component) {
            copy(__DIR__ . "/../../stubs/app/View/Components/{$component}", app_path("View/Components/{$component}"));
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
