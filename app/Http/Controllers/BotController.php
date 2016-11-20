<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{
    function __construct {

    }

    //all incoming links from Slack go here
    public function receive() {
    	ini_set("allow_url_fopen", 1);

    	$post = file_get_contents("php://input");
    	$data = json_decode($post);
    	$challenge = $data->challenge;
       
       if($challenge) {
          return verify($challenge);
       }

    }

//Events API verification
public function verify($challenge) {
    	//http_response_code(200);
    	header("HTTP/1.0 200 OK");
    	header("Content-Type: application/json");
    	$confirm = array('challenge' => $challenge);

    	return json_encode($confirm);
    }
}
