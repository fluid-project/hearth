<?php

namespace Hearth;

use Hearth\Commands\HearthCommand;
use Hearth\Components\Alert;
use Hearth\Components\LanguageSwitcher;
use Hearth\Components\LocaleSelect;
use Hearth\Components\PasswordConfirmation;
use Hearth\Components\Select;
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
            ->hasViewComponents('hearth', [
                Alert::class,
                LanguageSwitcher::class,
                LocaleSelect::class,
                PasswordConfirmation::class,
                Select::class,
            ])
            ->hasTranslations()
            ->hasMigrations(['create_organizations_table', 'create_memberships_table', 'create_invitations_table'])
            ->hasCommand(HearthCommand::class);
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
}
