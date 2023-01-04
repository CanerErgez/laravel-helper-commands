<?php

namespace Caner\LaravelHelperCommands\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

class ControllerService
{
    public static function getControllerMethods(): Collection
    {
        $controllerPaths = config('laravel-helper-commands.controller_paths');
        $allControllerMethods = [];
        $massiveString = '';

        foreach ($controllerPaths as $controllerPath) {
            $controllerPath = base_path().'/'.$controllerPath;

            collect(File::allFiles($controllerPath))->filter(function ($filename) {
                return Str::endsWith($filename, '.php');
            })->each(function ($phpFile) use (&$massiveString, &$allControllerMethods): void {
                $fileContents = file_get_contents($phpFile);
                $massiveString .= $fileContents;
                $functionNames = [];

                preg_match_all('/public function\s+([^ ]+?)\s*\(/', $fileContents, $functionNames);

                if (count($functionNames) > 0) {
                    foreach ($functionNames[1] as $fName) {
                        if ($fName === '__construct') {
                            continue;
                        }

                        $fullPath = str_replace('.php', '', $phpFile->getPathName().'@'.$fName);
                        $fullPath = str_replace(base_path().'/', '', $fullPath);
                        $allControllerMethods[] = str_replace('/', '\\', $fullPath);
                    }
                }
            });
        }

        sort($allControllerMethods);

        return collect($allControllerMethods);
    }

    public static function getMissingAuthorizedMethodList(): Collection
    {
        $controllers = RouteService::getRouteControllerList(true);

        $failedPermissions = collect();
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

                $filename = $method->getFileName();
                $startLine = $method->getStartLine();
                $endLine = $method->getEndLine();

                $source = implode(PHP_EOL, array_slice(file($filename), $startLine - 1, $endLine - $startLine + 1));

                if (! str_contains($source, '$this->authorize(')) {
                    $failedPermissions->add($controller.'@'.$method->getName());
                }
            }
        }

        return $failedPermissions;
    }
}
