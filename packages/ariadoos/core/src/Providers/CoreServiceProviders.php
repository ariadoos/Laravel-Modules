<?php

namespace Modules\Core\Providers;

use Modules\Core\Console\Commands\MakeApiControllerCommand;
use Modules\Core\Console\Commands\MakeInterfaceCommand;
use Modules\Core\Console\Commands\MakeRepositoryCommand;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\Commands\CreateModuleCommand;
use Modules\Core\Console\Commands\MakeApiResourceCommand;
use Modules\Core\Console\Commands\MakeModelCommand;
use Modules\Core\Console\Commands\MakeRequestCommand;
use Modules\Core\Console\Commands\MakeServiceCommand;
use Modules\Core\Console\Commands\MakeWebControllerCommand;
use Modules\Core\Console\Commands\MakeWebRouteCommand;
use Modules\Core\Console\Commands\MakeApiRouteCommand;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/core.php', 'core'
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateModuleCommand::class,
                MakeWebRouteCommand::class,
                MakeApiRouteCommand::class,
                MakeModelCommand::class,
                MakeRequestCommand::class,
                MakeApiResourceCommand::class,
                MakeInterfaceCommand::class,
                MakeRepositoryCommand::class,
                MakeApiControllerCommand::class,
                MakeWebControllerCommand::class,
                MakeServiceCommand::class,
            ]);
        }
    }
}
