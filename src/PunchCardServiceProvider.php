<?php

namespace TomasVotruba\PunchCard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TomasVotruba\PunchCard\Commands\PunchCardCommand;

class PunchCardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('punchcard')
            ->hasConfigFile()
            ->hasCommand(PunchCardCommand::class);
    }
}
