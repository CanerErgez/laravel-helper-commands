<?php

namespace Caner\LaravelHelperCommands;

use Caner\LaravelHelperCommands\Commands\MissingControllerMethodsCommand;
use Caner\LaravelHelperCommands\Commands\MissingRoutesCommand;
use Caner\LaravelHelperCommands\Commands\RoutePermissionCheckCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHelperCommandsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-helper-commands')
            ->hasConfigFile('laravel-helper-commands')
            ->hasCommand(RoutePermissionCheckCommand::class)
            ->hasCommand(MissingRoutesCommand::class)
            ->hasCommand(MissingControllerMethodsCommand::class);
    }
}
