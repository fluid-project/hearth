<?php

namespace Hearth;

use Hearth\Commands\HearthCommand;
use Hearth\View\Components\Alert;
use Hearth\View\Components\LanguageSwitcher;
use Hearth\View\Components\LocaleSelect;
use Hearth\View\Components\PasswordConfirmation;
use Hearth\View\Components\Select;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HearthServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the PackageServiceProvider.
     *
     * @see https://github.com/spatie/laravel-package-tools
     *
     * @param \Spatie\LaravelPackageTools\Package $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hearth')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations(['create_organizations_table', 'create_memberships_table', 'create_invitations_table'])
            ->hasCommand(HearthCommand::class);
    }

    /**
     * Custom logic which should be run at the start of the boot method of PackageServiceProvider
     *
     * @see https://github.com/spatie/laravel-package-tools#using-lifecycle-hooks
     *
     * @return void
     */
    public function bootingPackage()
    {
        $this->configureComponents();
    }

    /**
     * Custom logic which should be run at the end of the boot method of PackageServiceProvider
     *
     * @see https://github.com/spatie/laravel-package-tools#using-lifecycle-hooks
     *
     * @return void
     */
    public function packageBooted()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../database/migrations/create_users_table.php.stub' =>
                database_path('migrations/2014_10_12_000000_create_users_table.php'),
        ], 'hearth-migrations');
    }

    /**
     * Configure the Hearth Blade components.
     *
     * @return void
     */
    protected function configureComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            $this->registerComponent('alert');
            $this->registerComponent('button');
            $this->registerComponent('input');
            $this->registerComponent('label');
            $this->registerComponent('language-switcher');
            $this->registerComponent('locale-select');
            $this->registerComponent('select');
        });

        $this->loadViewComponentsAs('hearth', [
            Alert::class,
            LanguageSwitcher::class,
            LocaleSelect::class,
            PasswordConfirmation::class,
            Select::class,
        ]);
    }

    /**
     * Register the given component.
     *
     * @param  string  $component
     *
     * @return void
     */
    protected function registerComponent(string $component)
    {
        Blade::component('hearth::components.' . $component, 'hearth-' . $component);
    }
}
