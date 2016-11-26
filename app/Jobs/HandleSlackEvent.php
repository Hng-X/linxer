<?php

namespace App\Jobs;

use App\Models\Credential;
use App\Models\Link;
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
        //determine what kind of message this is: add, search, or not for us
        $text = $this->request['event']['text'];
        $text = $this->getMessageTypeAndParseText($text);

        $data = [];
        if ($text['type'] == 'add') {
            //add link to db
            if ($url = $this->sanitizeAndVerifyUrl($text["link"])) {
                $attributes = array(
                    "team_id" => $this->request['team_id'],
                    "url" => $url,
                    "user_id" => $this->request['event']['user'],
                    "channel_id" => $this->request['event']['channel'],
                    "title" => $this->getTitle($text["link"])
                );
                $link = Link::create($attributes);

                //respond
                $teamName = "";
                $teamLinksUrl = env('APP_URL') . "/links/" . $this->request['team_id'] . "-" . $teamName;
                $data['text'] = "Done! :+1: See all your team's links <$teamLinksUrl|here>. ";
                $data['channel'] = $this->request['event']['channel'];
                $data['team_id'] = $this->request['team_id'];
                $data['response_type'] = "saved";

                $response = $this->respond($data);
                Log::info("Received response:" . print_r($response, true));
            }
        }
    }


    public function getMessageTypeAndParseText($text)
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

    private function sanitizeAndVerifyUrl($text)
    {
        $text = filter_var($text, FILTER_SANITIZE_URL);
        return filter_var($text, FILTER_VALIDATE_URL);
    }

    private function getTitle($url)
    {
        $str = file_get_contents($url);
        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title); // ignore case
            return $title[1];
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
