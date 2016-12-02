<?php

namespace App\Jobs;

use App\Models\Credential;
use App\Models\Link;
use App\Models\Tag;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        if ($this->request['event']['type'] == "message") {
            $rawText = $this->request['event']['text'];
            $parsedText = $this->getMessageTypeAndParseText($rawText);
            Log::info("RAW TEXT: " . $rawText);
            Log::info("PARSED TEXT: " . print_r($parsedText, true));

            $data = array(
                'channel' => $this->request['event']['channel'],
                'team_id' => $this->request['team_id']
            );

            $teamLinksUrl = "https://slack.com/oauth/authorize?scope=identity.basic,identity.email,identity.team&client_id=104593454705.107498116711&redirect_uri=http://linxer.herokuapp.com/Auth/signin";

            if ($parsedText['type'] == 'add') {
                //add link to db
                $url = $this->sanitizeAndVerifyUrl($parsedText["link"]);
                if ($url) {
                    $linkId = $this->createLink($url);

                    if ($parsedText['tags']) {
                        $this->addTags($linkId, $parsedText['tags']);
                    }

                    $data['text'] = "Done! :+1: See all your team's links <$teamLinksUrl|here>. ";
                }
            } elseif ($parsedText['type'] == 'search') {
                //check if the tag corresponds to any link for the particular team

                $tag_term0 = $parsedText['query_terms'];
                $tag_term = implode("", $tag_term0);


                $team = $this->request['team_id'];
                $check = Link::where('team_id', $team)->where('title', "LIKE", "%$tag_term%")
                    ->get();
                //searching by title for now

                if ($check) {
                    $num = count($check);
                    if ($num > 0) {
                        ($num == 1) ? $num_link = 'link' : $num_link = 'links';

                        //$get_links = [];
                        $sn = 1;

                        $links = "";
                        foreach ($check as $link) {
                            //$output_text["body"] = "$sn <$link->url|$link->title>\n";
                            $links .= "$sn <$link->url|$link->title>\n";
                            //array_push($output_text['body'], $content);
                            $sn++;
                        }

                        $output_text = "Yo! I found `$num` $num_link on *$tag_term* \n$links \nCheck out all your team's links <$teamLinksUrl|here>.";
                    } else {
                        $output_text = "Sorry, I couldn't find any links matching *$tag_term*. Try refining your keywords, or check out all your team's links <$teamLinksUrl|here>.";
                    }

                    $data['text'] = $output_text;
                }
            } elseif ($parsedText['type'] == 'invalid') {
                //command not recognised
                $word = $parsedText['query'];

                $data['text'] = "Sorry, I didn't understand *$word.* I'm not that smart yet. :disappointed: \nTry using *add* to save a link, or *find* to search for a link.\nYou can also see all your team's links <$teamLinksUrl|here>.";
            }
            $response = $this->respond($data);
            Log::info("Received response:" . print_r($response, true));
        }
    }


    public function getMessageTypeAndParseText($text)
    {
        $tokens = explode(' ', $text);
        $botUserId = Credential::where('team_id', $this->request['team_id'])->get()->first()->bot_user_id;
        if ($tokens[0] == "<@$botUserId>") {
            if ($tokens[1] == "add" || $tokens[1] == "save") {
                return array(
                    'type' => 'add',
                    'link' => trim($tokens[2], "<>"),
                    'tags' => implode(' ', array_slice($tokens, 3)));
            } else if ($tokens[1] == "find" || $tokens[1] == "search") {
                return array(
                    'type' => 'search',
                    'query_terms' => array_slice($tokens, 2)
                );
            } else {
                return array(
                    'type' => 'invalid',
                    'query' => $tokens[1]
                );
            }
        }
    }

    private function sanitizeAndVerifyUrl($text)
    {
        $text = filter_var($text, FILTER_SANITIZE_URL);
        return filter_var($text, FILTER_VALIDATE_URL);
    }

    public function createLink($url)
    {
        $attributes = array(
            "team_id" => $this->request['team_id'],
            "url" => $url,
            "user_id" => $this->request['event']['user'],
            "channel_id" => $this->request['event']['channel'],
            "title" => $this->getTitle($url)
        );
        $link = Link::firstOrCreate($attributes);
        return $link->id;
    }

    private function getTitle($url)
    {
        try {
            $str = file_get_contents($url);
            if (strlen($str) > 0) {
                $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
                preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title); // ignore case
                $answer = $title[1];
            } else {
                $answer = parse_url($url)["host"];
            }
        } catch (\Exception $e) {
            $answer = parse_url($url)["host"];
        }
        return $answer;
    }

    public function addTags($linkId, $tagsString)
    {
        $link = Link::find($linkId);
        $tags = explode(",", $tagsString);
        $tagIds = [];
        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate(["name" => trim($tag)]);
            $tagIds[] = $tag->id;
        }
        $link->tags()->attach($tagIds);
    }

    /**
     * Posts responses to Slack
     */
    public function respond(array $data)
    {
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
