<?php

namespace RSolution\RCms\Http\View\Composers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ModalComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'route' =>  Request::url()
        ]);
    }
}
