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
            ->hasMigration('create_hearth_table')
            ->hasCommand(HearthCommand::class);
    }
}
