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
'redirect_uri' => urlencode(env('APP_URL').'/authorize'),
'code' => $code]]);
$response=json_decode($response->getBody(), true);
if($response['ok']===true) {
if(isset($response['access_token'])) {
$credential=new Credential();
$credential->access_token=$response['access_token'];
$credential->team_id=$response['team_id'];$credential->bot_user_id=$response['bot']['bot_user_id'];
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
return view('authorize', ['result' => $result]);
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
      'redirect_uri' => urlencode(env('APP_URL').'/signin'),
      'code' => $code]]);
      $response=json_decode($response->getBody(), true);
      if($response['ok']===true)
      {
        if(isset($response['access_token']))
        {
          $access_token=$response['access_token'];
          $slackUsers = $this->getUserFromToken($access_token);
          $teamName = $slackUsers['team']['name'];
          $teamId = $slackUsers['team']['id'];

          return redirect("/links/$teamId-$teamName");
        }
        else
        {
            $errorMsg=$response['error'];
        }
        return view('authorize', ['result' => $errorMsg]);
      }
    }

    /* Get User details from slack generated token */

    public function getUserFromToken($token)
    {
      $options = ['headers' => ['Accept' => 'application/json']];
      $endpoint = 'https://slack.com/api/users.identity?token='.$token;
      $response = $this->getHttpClient()->get($endpoint, $options)->getBody()->getContents();

      return json_decode($response, true);
    }
}
