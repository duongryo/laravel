<?php
namespace RTech\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class RTechServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'rtech');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->app->singleton(
             RTech\Repositories\PostRepositoryInterface::class,
             RTech\Repositories\PostRepository::class
        );
    
        $this->createRuleSlug();
    }

    private function createRuleSlug()
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
    }
}