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

    public function parseText($text)
    {
        $tokens=explode(' ', $text);
        if($tokens[0]=="@linxer") {
            if($tokens[1]=="add" || $tokens[1]=="save") {
                return array( 'type' => 'add',
                                      'link' => $tokens[2],
                                      'tags' => array_slice($tokens, 3));
             } else if ($tokens[1]=="find" || $tokens[1]=="search") {
                return array( 'type' => 'search'
                                      'query_terms' =>  array_slice($tokens, 2));
             }
        }
    }
}
