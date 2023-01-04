<?php

namespace Caner\LaravelHelperCommands\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;

class RouteService
{
    public static function getRouteControllerList($isPermissionCheck = false): Collection
    {
        $controllers = collect();

        foreach (Route::getRoutes() as $route) {
            $controllers->add(explode('@', $route->getAction()['controller'])[0]);
        }

        return $isPermissionCheck ? $controllers->unique() : $controllers
            ->unique()
            ->diff(collect(config('laravel-helper-commands.excluded_controllers_for_permission_check')));
    }

    public static function getRouteControllerMethods(): Collection
    {
        $controllers = self::getRouteControllerList();

        $allRouteControllerMethods = collect();
        foreach ($controllers as $controller) {
            $instance = new ReflectionClass($controller);

            foreach ($instance->getMethods() as $method) {
                if ($method->getName() === '__construct') {
                    continue;
                }

                if ($method->getModifiers() !== ReflectionMethod::IS_PUBLIC) {
                    continue;
                }

                if ($method->getDeclaringClass()->getName() !== $controller) {
                    continue;
                }

                $allRouteControllerMethods->add($controller.'@'.$method->getName());
            }
        }

        return $allRouteControllerMethods;
    }
}
