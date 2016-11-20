<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationsController extends Controller
{
    function __construct {

    }

    public function verify() {
    	$confirm = "header('HTTP/1.1 200 OK')"."header('Content-type:application/json')"."{'challenge':'3eZbrw1aBm2rZgRNFdxV2595E9CY3gmdALWMmHkvFXO7tYXAYM8P'}";

    	return $confirm;
    }
}
