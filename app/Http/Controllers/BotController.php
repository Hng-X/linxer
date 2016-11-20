<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EventsMiddleware;
use Illuminate\Http\Request;

class BotController extends Controller
{
    function __construct()
    {
        $this->middleware(EventsMiddleware::class);
    }

    //all incoming links from Slack go here
    public function receive() {

    }
}
