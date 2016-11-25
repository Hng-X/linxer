<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EventsMiddleware;
use App\Models\Credential;
use GuzzleHttp\Client;
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
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function receive(Request $request)
    {
        response('Ok', 200);
        $text = $request->input('event.text');
        $data = [];
        if ($this->parseText($text)['type'] == 'add') {
            $data['text'] = "Done! See all your team's links here. :blush:";
            $data['channel'] = $request->input('event.channel');
            $data['response_type'] = "saved";

            $this->respond($data);

        }

    }

    public function parseText($text)
    {
        $tokens = explode(' ', $text);
        if ($tokens[0] == "@linxer") {
            if ($tokens[1] == "add" || $tokens[1] == "save") {
                return array(
                    'type' => 'add',
                    'link' => $tokens[2],
                    'tags' => array_slice($tokens, 3));
            } else if ($tokens[1] == "find" || $tokens[1] == "search") {
                return array(
                    'type' => 'search',
                    'query_terms' => array_slice($tokens, 2));
            }
        }
    }

    /**
     * Posts responses to Slack
     */
    public function respond(array $data)
    {
        //if ($data['response_type'] == 'saved')
        $client = new Client();
        $response = $client->request('GET', 'https://slack.com/api/chat.postMessage',
            ['query' => [
                'token' => Credential::where('team_id', $data['team_id'])->first()->bot_user_token,
                'channel' => $data['channel'],
                'text' => $data['text']
            ]
            ]);
        return json_decode($response->getBody(), true);
    }

    public function test()
    {
        $data = [];
        $data['text'] = "Higuys... :blush:";
        $data['channel'] = "#bot-testing";
        $data['response_type'] = "saved";
        $data['team_id'] = "T32HFDCLR";

        $response = $this->respond($data);
        if ($response['ok'] === true) {
            return view('Auth/add', ['result' => "OK"]);
        } else return view('Auth/add', ['result' => $response['error']]);
    }

}
