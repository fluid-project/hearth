<?php

namespace Hearth\Commands;

use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class HearthCommand extends Command
{
    public $signature = 'hearth:install {--two-factor} {--organizations} {--resources}';

    public $description = 'Install Hearth.';

    public function handle()
    {
        if (! App::environment('testing')) {
            // Publish vendor files...
            $this->callSilent('vendor:publish', ['--tag' => 'hearth-config', '--force' => true]);
            $this->callSilent('vendor:publish', ['--tag' => 'hearth-migrations', '--force' => true]);
            $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
            $this->callSilent('vendor:publish', [
                '--provider' => 'ChinLeung\LaravelLocales\LaravelLocalesServiceProvider',
                '--tag' => 'config',
            ]);
            $this->callSilent('vendor:publish', [
                '--provider' => 'Spatie\GoogleFonts\GoogleFontsServiceProvider',
                '--tag' => 'google-fonts-config',
            ]);

            // Install NPM packages...
            $this->updateNodePackages(function ($packages) {
                return [
                    '@fluid-project/looseleaf' => '^1.6',
                    'alpinejs' => '^3.0',
                    'luxon' => '^2.0',
                ] + $packages;
            }, false);

            $this->updateNodePackages(function ($packages) {
                return [
                    'resolve-url-loader' => '^4.0.0',
                    'sass' => '^1.35',
                    'sass-loader' => '^12.1',
                ] + $packages;
            });

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
            $this->installMiddlewareAfter(
                'VerifyCsrfToken::class',
                '\ChinLeung\MultilingualRoutes\DetectRequestLocale::class'
            );

            // RedirectToPreferredLocale Middleware...
            if (! Str::contains(file_get_contents(app_path('Http/Kernel.php')), '\App\Http\Middleware\RedirectToPreferredLocale::class')) {
                $this->replaceInFile(
                    "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,",
                    "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'localize' => \App\Http\Middleware\RedirectToPreferredLocale::class,",
                    app_path('Http/Kernel.php')
                );
            }

            // RequirePassword Middleware...
            $this->replaceInFile(
                '\Illuminate\Auth\Middleware\RequirePassword::class',
                '\App\Http\Middleware\RequirePassword::class',
                app_path('Http/Kernel.php')
            );

            // FortifyServiceProvider...
            $this->installServiceProviderAfter('RouteServiceProvider', 'FortifyServiceProvider');

            // Ensure folders are in place...
            (new Filesystem())->ensureDirectoryExists(app_path('Actions/Fortify'));
            (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests'));
            (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests/Auth'));
            (new Filesystem())->ensureDirectoryExists(app_path('Http/Responses'));
            (new Filesystem())->ensureDirectoryExists(app_path('Mail'));
            (new Filesystem())->ensureDirectoryExists(app_path('Policies'));
            (new Filesystem())->ensureDirectoryExists(app_path('Rules'));
            (new Filesystem())->ensureDirectoryExists(app_path('View/Components'));

            // App stubs...
            $app_stubs = [
                'Actions/AcceptInvitation.php',
                'Actions/DestroyMembership.php',
                'Actions/UpdateMembership.php',
                'Actions/Fortify/CreateNewUser.php',
                'Actions/Fortify/PasswordValidationRules.php',
                'Actions/Fortify/RedirectIfTwoFactorAuthenticatable.php',
                'Actions/Fortify/UpdateUserPassword.php',
                'Actions/Fortify/UpdateUserProfileInformation.php',
                'Http/Controllers/InvitationController.php',
                'Http/Controllers/MembershipController.php',
                'Http/Controllers/OrganizationController.php',
                'Http/Controllers/ResourceController.php',
                'Http/Controllers/UserController.php',
                'Http/Controllers/VerifyEmailController.php',
                'Http/Middleware/Authenticate.php',
                'Http/Middleware/RedirectIfAuthenticated.php',
                'Http/Middleware/RedirectToPreferredLocale.php',
                'Http/Middleware/RequirePassword.php',
                'Http/Requests/Auth/LoginRequest.php',
                'Http/Requests/DestroyUserRequest.php',
                'Http/Requests/CreateInvitationRequest.php',
                'Http/Requests/CreateOrganizationRequest.php',
                'Http/Requests/DestroyOrganizationRequest.php',
                'Http/Requests/UpdateOrganizationRequest.php',
                'Http/Requests/CreateResourceRequest.php',
                'Http/Requests/DestroyResourceRequest.php',
                'Http/Requests/UpdateResourceRequest.php',
                'Http/Responses/FailedTwoFactorLoginResponse.php',
                'Http/Responses/LoginResponse.php',
                'Http/Responses/PasswordResetResponse.php',
                'Http/Responses/RegisterResponse.php',
                'Http/Responses/TwoFactorLoginResponse.php',
                'Mail/Invitation.php',
                'Models/User.php',
                'Models/Organization.php',
                'Models/Membership.php',
                'Models/Resource.php',
                'Models/Invitation.php',
                'Policies/OrganizationPolicy.php',
                'Policies/ResourcePolicy.php',
                'Policies/UserPolicy.php',
                'Providers/FortifyServiceProvider.php',
                'Rules/NotLastAdmin.php',
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
                copy(__DIR__ . "/../../stubs/config/{$config}", config_path($config));
            }
        }

        // Add languages
        if (! $this->option('no-interaction')) {
            $this->maybeAddLocale();
        }

        if (! App::environment('testing')) {
            // Route stubs...
            $route_stubs = [
                'fortify.php',
                'organizations.php',
                'resources.php',
                'web.php',
            ];

            foreach ($route_stubs as $route) {
                copy(__DIR__ . "/../../stubs/routes/{$route}", base_path("routes/{$route}"));
            }

            // Factories...
            $factories = [
                'InvitationFactory.php',
                'OrganizationFactory.php',
                'ResourceFactory.php',
                'UserFactory.php',
            ];

            foreach ($factories as $factory) {
                copy(__DIR__ . "/../../database/factories/{$factory}", base_path("database/factories/{$factory}"));
            }

            // Tests...
            $test_stubs = [
                'AccountDeletionTest.php',
                'AuthenticationTest.php',
                'EmailVerificationTest.php',
                'LocalizationTest.php',
                'OrganizationTest.php',
                'PasswordChangeTest.php',
                'PasswordConfirmationTest.php',
                'PasswordResetTest.php',
                'RegistrationTest.php',
                'ResourceTest.php',
                'TwoFactorAuthenticationTest.php',
            ];

            (new Filesystem())->delete(base_path('tests/Feature/ExampleTest.php'));

            foreach ($test_stubs as $test) {
                copy(__DIR__ . "/../../stubs/tests/{$test}", base_path("tests/Feature/{$test}"));
            }

            // Views...
            (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/resources/views/', resource_path('views'));

            // View components...
            $components = [
                'AppLayout.php',
                'GuestLayout.php',
            ];

            foreach ($components as $component) {
                copy(__DIR__ . "/../../stubs/app/View/Components/{$component}", app_path("View/Components/{$component}"));
            }

            // Fonts...
            $this->replaceInFile(
                'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700',
                'https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,400;0,700;1,400;1,700&display=swap',
                config_path('google-fonts.php')
            );

            // Mix configuration...
            copy(__DIR__ . '/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

            // Assets...
            (new Filesystem())->delete(resource_path('css/app.css'));
            (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/resources/css/', resource_path('css'));
            (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/resources/js/', resource_path('js'));

            // Language files...
            (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/resources/lang/', resource_path('lang'));

            // Enable two-factor authentication
            if ($this->option('two-factor')) {
                $this->replaceInFile(
                    "// Features::twoFactorAuthentication([ 'confirmPassword' => true ]),",
                    "Features::twoFactorAuthentication([ 'confirmPassword' => true ]),",
                    config_path('fortify.php')
                );
            }

            if ($this->option('organizations')) {
                $this->replaceInFile(
                    "'organizations' => [
        'enabled' => false,",
                    "'organizations' => [
        'enabled' => true,",
                    config_path('hearth.php')
                );
            }

            if ($this->option('resources')) {
                $this->replaceInFile(
                    "'resources' => [
        'enabled' => false,",
                    "'resources' => [
        'enabled' => true,",
                    config_path('hearth.php')
                );
            }
        }

        $this->line('');
        $this->info('Hearth scaffolding installed successfully.');
        $this->comment('Please execute "npm install" to install and build your assets.');
    }

    /**
     * Add a new locale to config/locales.php based on user input.
     *
     * @param  string  $after
     * @return void
     */
    protected function maybeAddLocale($after = 'fr')
    {
        $continue = $this->confirm('Do you want to add support for an additional locale?', true);

        if ($continue) {
            $languages = (new LanguageRepository())->getList();

            $language = $this->anticipate('Choose a locale', $languages);

            if (in_array($language, array_keys($languages))) {
                $language_code = $language;
            } elseif ($language) {
                $language_code = array_search($language, $languages);
            } else {
                $language_code = false;
            }

            if ($language_code) {
                if (! App::environment('testing')) {
                    $this->replaceInFile(
                        "'{$after}',",
                        "'{$after}',
        '{$language_code}',",
                        config_path('locales.php')
                    );
                }

                $this->info("{$languages[$language_code]} added to locales!");
            } else {
                $language_code = $after;
                $this->error('You entered an invalid locale code. Please try again, or type "no" to proceed without adding more locales.');
            }

            $this->maybeAddLocale($language_code);
        }
    }

    /**
     * Install the service provider in the application configuration file.
     *
     * @param  string  $after
     * @param  string  $name
     * @return void
     */
    protected function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }

    /**
     * Install the middleware to a group in the application Http Kernel.
     *
     * @param  string  $after
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    protected function installMiddlewareAfter($after, $name, $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after.',',
                $after.','.PHP_EOL.'            '.$name.',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        $packages['scripts']['postinstall'] = 'npm run dev';

        ksort($packages['scripts']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem(), function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
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
