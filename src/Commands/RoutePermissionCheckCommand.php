<?php

namespace Caner\LaravelHelperCommands\Commands;

use Caner\LaravelHelperCommands\Services\ControllerService;
use Illuminate\Console\Command;

class RoutePermissionCheckCommand extends Command
{
    public $signature = 'dev:permission-check';

    public $description = 'Check controller action permissions';

    public function handle()
    {
        $failedPermissions = ControllerService::getMissingAuthorizedMethodList();

        if ($failedPermissions->isEmpty()) {
            $this->info('All controllers have permission checks.');
        } else {
            $this->info('The following controllers/methods are missing permission checks: '.PHP_EOL.PHP_EOL.$failedPermissions->implode(PHP_EOL));
        }

        return Command::SUCCESS;
    }
}
