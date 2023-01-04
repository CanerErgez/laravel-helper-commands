<?php

namespace Caner\LaravelHelperCommands\Commands;

use Caner\LaravelHelperCommands\Services\ControllerService;
use Caner\LaravelHelperCommands\Services\RouteService;
use Illuminate\Console\Command;

class MissingControllerMethodsCommand extends Command
{
    public $signature = 'dev:missing-controller-methods';

    public $description = 'Check missing controller methods';

    public function handle()
    {
        $controllerList = ControllerService::getControllerMethods();
        $routeControllerList = RouteService::getRouteControllerMethods();

        $missingControllerMethods = $controllerList->diff($routeControllerList);

        if ($missingControllerMethods->isEmpty()) {
            $this->info('All available controller methods have a route.');
        } else {
            $this->info('The following controllers/methods are missing in routes: '.PHP_EOL.PHP_EOL.$missingControllerMethods->implode(PHP_EOL));
        }

        return Command::SUCCESS;
    }
}
