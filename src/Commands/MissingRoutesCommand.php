<?php

namespace Caner\LaravelHelperCommands\Commands;

use Caner\LaravelHelperCommands\Services\ControllerService;
use Caner\LaravelHelperCommands\Services\RouteService;
use Illuminate\Console\Command;

class MissingRoutesCommand extends Command
{
    public $signature = 'dev:missing-routes';

    public $description = 'Check missing routes';

    public function handle()
    {
        $controllerList = ControllerService::getControllerMethods();
        $routeControllerList = RouteService::getRouteControllerMethods();

        $missingRoutes = $routeControllerList->diff($controllerList);

        if ($missingRoutes->isEmpty()) {
            $this->info('All available routes have a controller methods.');
        } else {
            $this->info('The following routes are missing in controller methods: '.PHP_EOL.PHP_EOL.$missingRoutes->implode(PHP_EOL));
        }

        return Command::SUCCESS;
    }
}
