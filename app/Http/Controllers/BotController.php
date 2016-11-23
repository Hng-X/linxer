<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EventsMiddleware;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Storage;

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
    public function receive(Request $request)
    {
        $text=$request->input('event.text');
        $data = [];
        if ($this->parseText($text)['type']=='add') {
            $data['text'] = "Done! See all your team's links here. :blush:";
            $data['channel'] = $request->input('event.channel');
            $data['response_type'] = "saved";
            
            $this->respond($data);
            
            return response('Ok', 200);
        }

    }

    /**
     * Posts responses to Slack
     */
    public function respond(array $data)
    {
//if ($data['response_type'] == 'saved')
$client=new Client();
             $response=$client->request('GET', 'https://slack.com/api/chat.postMessage',
['query' => [
'token' => Storage::get('bot_token.dat'),
'channel'=> $data['channel'],
'text' => $data['text']]]);
return json_decode($response->getBody(), true);
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
                return array( 'type' => 'search',
                                      'query_terms' =>  array_slice($tokens, 2));
             }
        }
    }

public function test()
{
        $data = [];
            $data['text'] = "Done! See all your team's links here. :blush:";
            $data['channel'] = "#library-bot";
            $data['response_type'] = "saved";
            
            $response=$this->respond($data);
             if($response['ok']===true) {
return view('authorize', ['result' => "OK"]);
} else return view('authorize', ['result' => $response['error']]);
}

}
