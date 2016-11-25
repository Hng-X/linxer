<?php

namespace App\Http\Controllers;


use App\Models\Credential;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function authorizeSlack()
    {
         $code=$_GET['code'];
         $client=new Client();
         $response=$client->request('GET', 'https://slack.com/api/oauth.access',
['query' => ['client_id' => '104593454705.107498116711',
'client_secret' => env('SLACK_CLIENT_SECRET'),
//'redirect_uri' => urlencode(env('SLACK_REDIRECT_CALLBACK_URL').'/add'),
'code' => $code]]);
$response=json_decode($response->getBody(), true);
if($response['ok']===true) {
if(isset($response['access_token'])) {
$credential=new Credential();
$credential->access_token=$response['access_token'];
$credential->team_id=$response['team_id'];
$credential->bot_user_id=$response['bot']['bot_user_id'];
$credential->bot_access_token=$response['bot']['bot_access_token'];
$credential->save();
}
else {
Storage::put('token.dat', $response['stuff']['access_token']);
}
$result="Authorized";
}
else {
$result=$response['error'];
}
return view('Auth/add', ['result' => $result]);
    }

    /* Redirects user to teams links Page
    *
    *
    */
    public function redirectUsertoTeamLinks()
    {
      $code=$_GET['code'];
      $client=new Client();
      $response=$client->request('GET', 'https://slack.com/api/oauth.access',
      ['query' => ['client_id' => '104593454705.107498116711',
      'client_secret' => env('SLACK_CLIENT_SECRET'),
      //'redirect_uri' => urlencode(env('SLACK_REDIRECT_CALLBACK_URL').'/signin'),
      'code' => $code]]);
      $response=json_decode($response->getBody(), true);
      if($response['ok']===true)
      {
        if(isset($response['access_token']))
        {
          $access_token=$response['access_token'];

          $interactUser=$client->request('GET', 'https://slack.com/api/users.identity?token'.$access_token);
          $interactResponse= json_decode($interactUser->getBody()->getContents(), true);

          var_dump($interactResponse);

          //$teamId = $interactResponse['team']['id'];
          //teamName = $interactResponse['team']['name'];

          //return redirect("/links/$teamId-$teamName");
        }
        else
        {
            $errorMsg=$response['error'];
        }
        return view('Auth/signin', ['result' => $errorMsg]);
      }
    }
}
