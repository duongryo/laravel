<?php

namespace RSolution\RCms\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use RSolution\RCms\Http\View\Composers\ModalComposer;
use RSolution\RCms\Http\View\Composers\ShareasaleComposer;
use RSolution\RCms\Http\View\Composers\SidebarComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'rcms::layout.sidebar',
            SidebarComposer::class
        );

        View::composer(
            'rcms::components.shareasale',
            ShareasaleComposer::class
        );


        // Using class based composers...
        // View::composer(
        //     'rcms::components.modals.add',
        //     ModalComposer::class
        // );
    }
}
