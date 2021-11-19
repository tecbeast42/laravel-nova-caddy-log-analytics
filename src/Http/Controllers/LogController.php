<?php

namespace Tecbeast\CaddyAnalytics\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use function explode;

class LogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $log = Storage::disk('log')->get('caddy.log');
        $logEntires = collect(explode("\n", $log));

        return $logEntires->map(fn ($entry) => json_decode($entry))->filter();
    }
}
