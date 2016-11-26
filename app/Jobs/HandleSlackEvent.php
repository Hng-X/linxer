<?php

namespace App\Jobs;

use App\Models\Credential;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleSlackEvent implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $text = $this->request['event']['text'];
        $data = [];
        if ($this->parseText($text)['type'] == 'add') {
            $data['text'] = "Done! See all your team's links here. :+1:";
            $data['channel'] = $this->request['event']['channel'];
            $data['team_id'] = $this->request['team_id'];
            $data['response_type'] = "saved";

            $response = $this->respond($data);
            Log::info("Received response:" . print_r($response, true));
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
                'token' => Credential::where('team_id', $data['team_id'])->first()->bot_access_token,
                'channel' => $data['channel'],
                'text' => $data['text']
            ]
            ]);
        return json_decode($response->getBody(), true);
    }

}
