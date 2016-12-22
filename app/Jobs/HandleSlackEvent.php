<?php

namespace App\Jobs;

use DB;
use App\Models\Credential;
use App\Models\Link;
use App\Models\Tag;
use App\Models\Link_Tag;
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
                    if ($parsedText['tags']) {
                        $tags = $parsedText['tags'];
                        $this->createLink($url, $tags);

                        //$linkId = $this->createLink($url, $tags);
                        //$this->addTags($linkId, $parsedText['tags']);
                    }
                    else {
                        $this->createLink($url, null);
                    }
                /*
                    else {  //IF THERE ARE NOT TAGS, ADD LINK TITLE AS A TAG
                        $this->addTags($params['link_id'], $params['link_title']);
                    }
                */

                    $responses=array(
                         "Done! :+1: See all your team's <$teamLinksUrl|here>.",
                         "Added! <$teamLinksUrl|Here> are all your team's links. :sunglasses:",
                        "Link saved! Rest easy, Linxer's got ya back. :muscle:",
                        "Mission Accomplished, boss!"
                    );

                    $data['text'] = $responses[array_rand($responses)];
                }
                else {
                   $responses=array(
                        "I'm sorry, boss. I couldn't save that. Not a valid link. Why not check it again?",
                                          "Oops, that doesn't look like a valid link. Maybe you mistyped something?");
                        $data['text'] =  $responses[array_rand($responses)];
                }
            } 
            elseif ($parsedText['type'] == 'search') {
                //check if the tag corresponds to any link for the particular team

                $tag_term0 = $parsedText['query_terms'];
                $tag_term = implode(" ", $tag_term0);

                $team = $this->request['team_id'];
            
            
                //$check = Link::where(DB::raw("team_id = '$team' AND tags IN '$tag_term'"));//->get();

                $check = Link::where('tags', 'ILIKE', '%$tag_term%')->get();

                //selec(DB::raw("links WHERE team_id = '$team' AND tags IN '$tag_term'");
                            //where('team_id', $team)
                            //->select('tags', 'ILIKE', $tag_term)
                            
                //where('title', 'ILIKE', '%$tag_term%')                         ->
                            //->where('tags', 'ILIKE', '%$tag_term%')   //"ILIKE" is not a typo. it's needed for case-insensitive pattern matching in Postgres.
                                                         
                            //searching by title for now
            
            /* 
                //search by tags
                $check = Link_Tag::leftjoin('tags', 'tags.id', '=', 'link_tag.tag_id')
                                //->leftjoin('links', 'links.id', '=', 'link_tag.link_id')
                               // ->select('links.url as url', 'links.title as title')
                                //->where('links.team_id', '=', $team)
                                ->select('tags.name')
                                ->where('tags.name', 'ILIKE', '%$tag_term%')                            
                                ->get();
           

                $check = Tag::get(); //where('name', 'ILIKE', '%$tag_term%')->
            */

                if ($check) {
                    $num = count($check);
                    if ($num > 0) {
                        ($num == 1) ? $num_link = 'link' : $num_link = 'links';

                        //$get_links = [];
                        $sn = 1;

                        $links = implode("", $check);
                        foreach ($check as $link) {
                            //$output_text["body"] = "$sn <$link->url|$link->title>\n";
                            $links .= "$sn <$link->url|$link->title>\n";         // $link->name     <$link->url|$link->title>   
                            //array_push($output_text['body'], $content);
                            $sn++;
                        }
                            $responses=array(
                            "All done, captain! Got `$num` $num_link on *$tag_term* \n\n$links \n\n<$teamLinksUrl|Here's> all the team's links, too.",
                            "Here you go! I found `$num` $num_link on *$tag_term* \n\n$links \n\nCheck out all your team's links <$teamLinksUrl|here>.");
                            $output_text =$responses[array_rand($responses)];
                    } else {
                        $output_text = "I did my best, but I couldn't find any links matching *$tag_term*. :cry: Try refining your keywords, or maybe <$teamLinksUrl|take a look at your team's links>.";
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
                    'link' => strtok(trim($tokens[2], "<>"), '|'),
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

    public function createLink($url, $tags)
    {
        ($tags != null) ? $_tags = $tags : $_tags = '';

        $attributes = array(
            "team_id" => $this->request['team_id'],
            "url" => $url,
            "user_id" => $this->request['event']['user'],
            "channel_id" => $this->request['event']['channel'],
            "title" => $this->getTitle($url),
            "tags" => $_tags
        );

        $link = Link::firstOrCreate($attributes);

    /*
        //also return link title. the link title will be used as a tag if no tags are added to the 'add' post
        $params = [];
        $params['link_id'] = 
        $params['link_title'] = $link->title;
    */

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
