<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationsController extends Controller
{
    function __construct {

    }

    public function verify() {
    	ini_set("allow_url_fopen", 1);

    	$post = file_get_contents("php://input");
    	$data = json_decode($post);
    	$challenge = $data->challenge;

    	//http_response_code(200);
    	header("HTTP/1.0 200 OK");
    	header('Content-Type: application/json');
    	$confirm = {'challenge': $challenge};

    	return json_encode($confirm);

    	//return $confirm;
    	//return
    }
}
