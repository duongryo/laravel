<?php

namespace RSolution\RCms\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use RSolution\RCms\Console\Commands\CheckInvalidUser;
use RSolution\RCms\Console\Commands\CreateAdmin;
use RSolution\RCms\Console\Commands\DailyUpdate;
use RSolution\RCms\Console\Commands\DefaultConfig;

class RCmsServiceProvider extends ServiceProvider
{
    /**
     * Register config file here
     * alias => path
     */
    private $configFile = [
        'rcms-services' => '/../../config/services.php',
        'rcms-core' => '/../../config/core.php',
    ];

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        // register your config file here
        foreach ($this->configFile as $alias => $path) {
            $this->mergeConfigFrom(__DIR__ . "/" . $path, $alias);
        }
        // register your event
        $this->app->register(EventServiceProvider::class);
        // register your view
        $this->app->register(ViewServiceProvider::class);
    }

    public function boot()
    {
        Paginator::useBootstrap();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/core.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'rcms');
        $this->commands([
            DefaultConfig::class,
            CreateAdmin::class,
            DailyUpdate::class,
            CheckInvalidUser::class
        ]);
    }
}
