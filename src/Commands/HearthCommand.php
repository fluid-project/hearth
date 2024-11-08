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

        $this->filesystem = new Filesystem;
    }

    public function handle()
    {
        if (! App::environment('testing')) {

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
                    'sass' => '^1.53',
                ] + $packages;
            });
            $this->flushNodeModules();

            // Ensure folders are in place...
            $this->filesystem->ensureDirectoryExists(lang_path('fr'));

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

            // Vite configuration...
            copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));

            // Larastan/PHPStan configuration
            copy(__DIR__.'/../../stubs/phpstan.neon.dist', base_path('phpstan.neon.dist'));
        }

        // Add languages
        if (! $this->option('no-interaction')) {
            $this->maybeAddLocale();
        }

        $this->line('');
        $this->info('Hearth scaffolding installed successfully.');
        $this->comment('Please execute "npm install" to install and build your assets.');
    }

    /**
     * Add a new locale to config/locales.php based on user input.
     *
     * @return void
     */
    protected function maybeAddLocale(string $after = 'fr')
    {
        $continue = $this->confirm('Do you want to add support for an additional locale?', true);

        if ($continue) {
            $languages = (new LanguageRepository)->getList();

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
     * Install the middleware to a group in the application Http Kernel.
     *
     * @return void
     */
    protected function installMiddlewareBefore(string $before, string $name, string $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('bootstrap/app.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (! Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $before,
                $name.','.PHP_EOL.'            '.$before,
                $middlewareGroup,
            );

            file_put_contents(app_path('bootstrap/app.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }

    /**
     * Update the "package.json" file.
     *
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
     * @return void
     */
    protected function replaceInFile(string $search, string $replace, string $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
