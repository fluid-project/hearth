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
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
        $this->callSilent('vendor:publish', [
            '--provider' => 'ChinLeung\LaravelLocales\LaravelLocalesServiceProvider',
            '--tag' => 'config',
        ]);

        // Install NPM packages...
        $this->updateNodePackages(function ($packages) {
            return [
                '@accessibility-in-action/looseleaf' => '^1.3',
                'alpinejs' => '^3.0',
                'modern-css-reset' => '^1.4',
            ] + $packages;
        });

        $this->updateNodePackages(function ($packages) {
            return [
                'chokidar' => '^3.5',
            ] + $packages;
        }, true);

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
        $this->installMiddlewareAfter('VerifyCsrfToken::class', '\ChinLeung\MultilingualRoutes\DetectRequestLocale::class');

        // RedirectToPreferredLocale Middleware...
        $this->replaceInFile(
            "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,",
            "'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'localize' => \App\Http\Middleware\RedirectToPreferredLocale::class,",
            app_path('Http/Kernel.php')
        );

        // FortifyServiceProvider...
        $this->installServiceProviderAfter('RouteServiceProvider', 'FortifyServiceProvider');

        // Ensure folders are in place...
        (new Filesystem())->ensureDirectoryExists(app_path('Actions/Fortify'));
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Requests/Auth'));
        (new Filesystem())->ensureDirectoryExists(app_path('Http/Responses'));
        (new Filesystem())->ensureDirectoryExists(app_path('Policies'));
        (new Filesystem())->ensureDirectoryExists(app_path('Rules'));
        (new Filesystem())->ensureDirectoryExists(app_path('View/Components'));

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
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/', resources_path('views'));

        // View components...
        $components = [
            'AppLayout.php',
            'GuestLayout.php',
            'LanguageSwitcher.php',
        ];

        foreach ($components as $component) {
            copy(__DIR__ . "/../../stubs/app/View/Components/{$component}", app_path("View/Components/{$component}"));
        }

        // Mix configuration...
        copy(__DIR__ . '/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        // Assets...
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/css/', resources_path('css'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/', resources_path('js'));


        $this->line('');
        $this->info('Inertia scaffolding installed successfully.');
        $this->comment('Please execute "npm install && npm run dev" to build your assets.');
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
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
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
        tap(new Filesystem, function ($files) {
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
