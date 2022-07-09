<?php

namespace RSolution\RCms\Http\View\Composers;

use Illuminate\View\View;
use RSolution\RCms\Repositories\ConfigRepository;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = (new ConfigRepository)->getByKey('sidebar');
        $public = [];
        $private = [];
        if ($data)
            foreach ($data as $item) {
                $object = (object) $item->value;
                $object->public ?
                    array_push($public, $object) :
                    array_push($private, $object);
            }

        $view->with([
            'public' => $public,
            'private' => $private
        ]);
    }
}
