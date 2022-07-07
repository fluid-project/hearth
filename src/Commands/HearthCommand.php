<?php

namespace Hearth\Commands;

use CommerceGuys\Intl\Language\LanguageRepository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class HearthCommand extends Command
{
    public $signature = 'hearth:install {--two-factor}';

    public $description = 'Install Hearth.';

    protected Filesystem $filesystem;

    public function __construct()
    {
        parent::__construct();

        $this->filesystem = new Filesystem();
    }

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

            $this->flushNodeModules();

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
            $this->installMiddlewareBefore(
                '\App\Http\Middleware\EncryptCookies::class',
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
            $this->filesystem->ensureDirectoryExists(app_path('Actions/Fortify'));
            $this->filesystem->ensureDirectoryExists(app_path('Http/Requests'));
            $this->filesystem->ensureDirectoryExists(app_path('Http/Requests/Auth'));
            $this->filesystem->ensureDirectoryExists(app_path('Http/Responses'));
            $this->filesystem->ensureDirectoryExists(app_path('Mail'));
            $this->filesystem->ensureDirectoryExists(app_path('Policies'));
            $this->filesystem->ensureDirectoryExists(app_path('Rules'));
            $this->filesystem->ensureDirectoryExists(app_path('View/Components'));
            $this->filesystem->ensureDirectoryExists(lang_path('fr'));

            // App stubs...
            $app_stubs = array_merge(
                $this->filesystem->glob(__DIR__.'/../../stubs/app/**/*.php'),
                $this->filesystem->glob(__DIR__.'/../../stubs/app/**/**/*.php')
            );

            foreach ($app_stubs as $stub) {
                copy($stub, str_replace(__DIR__.'/../../stubs/app', app_path(), $stub));
            }

            // Config stubs...
            $config_stubs = $this->filesystem->glob(__DIR__.'/../../stubs/config/*.php');

            foreach ($config_stubs as $stub) {
                copy($stub, str_replace(__DIR__.'/../../stubs/config', config_path(), $stub));
            }

            // Database factories...
            $factories = $this->filesystem->glob(__DIR__.'/../../database/factories/*.php');

            foreach ($factories as $stub) {
                copy($stub, str_replace(__DIR__.'/../../database/factories', base_path('database/factories'), $stub));
            }

            // Language stubs...
            $lang_stubs = $this->filesystem->glob(__DIR__.'/../../stubs/lang/**/*.php');

            foreach ($lang_stubs as $stub) {
                copy($stub, str_replace(__DIR__.'/../../stubs/lang', lang_path(), $stub));
            }

            // Resource stubs...
            $this->filesystem->delete(resource_path('css/app.css'));
            $this->filesystem->copyDirectory(__DIR__.'/../../stubs/resources/css/', resource_path('css'));
            $this->filesystem->copyDirectory(__DIR__.'/../../stubs/resources/js/', resource_path('js'));
            $this->filesystem->copyDirectory(__DIR__.'/../../stubs/resources/views/', resource_path('views'));

            // Route stubs...
            $route_stubs = $this->filesystem->glob(__DIR__.'/../../stubs/routes/*.php');

            foreach ($route_stubs as $stub) {
                copy($stub, str_replace(__DIR__.'/../../stubs/routes', base_path('routes/'), $stub));
            }

            // Test stubs...
            $this->filesystem->delete(base_path('tests/Feature/ExampleTest.php'));
            $this->filesystem->delete(base_path('tests/Unit/ExampleTest.php'));

            $test_stubs = $this->filesystem->glob(__DIR__.'/../../stubs/tests/**/*.php');

            foreach ($test_stubs as $stub) {
                copy($stub, str_replace(__DIR__.'/../../stubs/tests', base_path('tests'), $stub));
            }

            // Vite configuration...
            copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));

            // Larastan/PHPStan configuration
            copy(__DIR__.'/../../stubs/phpstan.neon.dist', base_path('phpstan.neon.dist'));
        }

        // Add languages
        if (! $this->option('no-interaction')) {
            $this->maybeAddLocale();
        }

        if (! App::environment('testing')) {
            // Fonts...
            $this->replaceInFile(
                'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700',
                'https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,400;0,700;1,400;1,700&display=swap',
                config_path('google-fonts.php')
            );
        }

        // Enable two-factor authentication
        if ($this->option('two-factor')) {
            $this->replaceInFile(
                "// Features::twoFactorAuthentication([ 'confirmPassword' => true ]),",
                "Features::twoFactorAuthentication([ 'confirmPassword' => true ]),",
                config_path('fortify.php')
            );
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
    protected function maybeAddLocale(string $after = 'fr')
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
    protected function installServiceProviderAfter(string $after, string $name)
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
     * @param  string  $before
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    protected function installMiddlewareBefore(string $before, string $name, string $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $before,
                $name.','.PHP_EOL.'            '.$before,
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
    protected static function updateNodePackages(callable $callback, bool $dev = true)
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

        $packages['scripts']['postinstall'] = 'npm run build';

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
    protected function flushNodeModules()
    {
        $this->filesystem->deleteDirectory(base_path('node_modules'));
        $this->filesystem->delete(base_path('yarn.lock'));
        $this->filesystem->delete(base_path('package-lock.json'));
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile(string $search, string $replace, string $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
