<?php

namespace Tecbeast\CaddyAnalytics;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class CaddyAnalytics extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('caddy-analytics', __DIR__.'/../dist/js/tool.js');
        Nova::style('caddy-analytics', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('caddy-analytics::navigation');
    }
}
