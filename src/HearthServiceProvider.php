<?php

namespace Hearth;

use Hearth\Commands\HearthCommand;
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
            ->hasCommand(HearthCommand::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_users_table.php.stub' =>
                    database_path('migrations/2014_10_12_000000_create_users_table.php'),
            ], 'migrations');
        }
    }
}
