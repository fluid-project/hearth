<?php

namespace Hearth;

use Hearth\Components\Alert;
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
use Hearth\Components\RadioButton;
use Hearth\Components\RadioButtons;
use Hearth\Components\Select;
use Hearth\Components\Textarea;
use Hearth\Components\TranslatableInput;
use Hearth\Components\TranslatableTextarea;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HearthServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hearth')
            ->hasAssets()
            ->hasViews()
            ->hasViewComponent('hearth', Alert::class)
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
            ->hasViewComponent('hearth', RadioButton::class)
            ->hasViewComponent('hearth', RadioButtons::class)
            ->hasViewComponent('hearth', Select::class)
            ->hasViewComponent('hearth', Textarea::class)
            ->hasViewComponent('hearth', TranslatableInput::class)
            ->hasViewComponent('hearth', TranslatableTextarea::class)
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishAssets();
            });
    }
}
