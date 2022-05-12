<?php

namespace Hearth;

use Hearth\Commands\HearthCommand;
use Hearth\Components\Alert;
use Hearth\Components\Button;
use Hearth\Components\Checkbox;
use Hearth\Components\Checkboxes;
use Hearth\Components\DateInput;
use Hearth\Components\Error;
use Hearth\Components\Hint;
use Hearth\Components\Input;
use Hearth\Components\Label;
use Hearth\Components\LanguageSwitcher;
use Hearth\Components\LocaleSelect;
use Hearth\Components\PasswordConfirmation;
use Hearth\Components\RadioButtons;
use Hearth\Components\Select;
use Hearth\Components\Textarea;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HearthServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the PackageServiceProvider.
     *
     * @see https://github.com/spatie/laravel-package-tools
     *
     * @param Package $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hearth')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponent('hearth', Alert::class)
            ->hasViewComponent('hearth', Button::class)
            ->hasViewComponent('hearth', Checkbox::class)
            ->hasViewComponent('hearth', Checkboxes::class)
            ->hasViewComponent('hearth', DateInput::class)
            ->hasViewComponent('hearth', Error::class)
            ->hasViewComponent('hearth', Hint::class)
            ->hasViewComponent('hearth', Input::class)
            ->hasViewComponent('hearth', Label::class)
            ->hasViewComponent('hearth', LanguageSwitcher::class)
            ->hasViewComponent('hearth', LocaleSelect::class)
            ->hasViewComponent('hearth', PasswordConfirmation::class)
            ->hasViewComponent('hearth', RadioButtons::class)
            ->hasViewComponent('hearth', Select::class)
            ->hasViewComponent('hearth', Textarea::class)
            ->hasTranslations()
            ->hasMigrations([
                'update_users_table',
                'create_organizations_table',
                'create_resources_table',
            ])
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

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
