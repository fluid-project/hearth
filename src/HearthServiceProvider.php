<?php

namespace Hearth;

use Hearth\Commands\HearthCommand;
use Hearth\View\Components\Alert;
use Hearth\View\Components\LocaleSelect;
use Hearth\View\Components\Select;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HearthServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('hearth')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasCommand(HearthCommand::class);
    }

    public function bootingPackage()
    {
        $this->configureComponents();
    }

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
            $this->registerComponent('locale-select');
            $this->registerComponent('select');
        });

        $this->loadViewComponentsAs('hearth', [
            Alert::class,
            LocaleSelect::class,
            Select::class,
        ]);
    }

    /**
     * Register the given component.
     *
     * @param  string  $component
     * @return void
     */
    protected function registerComponent(string $component)
    {
        Blade::component('hearth::components.' . $component, 'hearth-' . $component);
    }
}
