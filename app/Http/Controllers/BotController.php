<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EventsMiddleware;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Ensures the app has been verified and the token is correct
     */
    function __construct()
    {
        $this->middleware(EventsMiddleware::class);
    }

    /**
     * Handles events received from Slack
     */
    public function receive()
    {

    }

    /**
     * Posts responses to Slack
     */
    public function respond()
    {

    }
}
