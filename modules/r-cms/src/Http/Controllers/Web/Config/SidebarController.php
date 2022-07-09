<?php

namespace RSolution\RCms\Http\Controllers\Web\Config;

class SidebarController extends ConfigController
{
    public function getView()
    {
        return 'rcms::pages.config.sidebar.index';
    }

    public function getKey()
    {
        return 'sidebar';
    }
}
