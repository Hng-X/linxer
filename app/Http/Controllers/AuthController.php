<?php

namespace App\Http\Controllers;


use Storage;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function authorizeSlack()
    {
         $code=$_GET['code'];
         $client=new Client();
         $response=$client->request('GET', 'https://slack.com/api/oauth.access',
['query' => ['client_id' => '104593454705.107498116711','client_secret' => env('SLACK_CLIENT_SECRET'),'code' => $code]]);
$response=json_decode($response->getBody(), true);
if($response['ok']===true) {
if(isset($response['access_token'])) {
Storage::put('token.dat', $response['access_token']);
Storage::put('bot_id.dat', $response['bot']['bot_user_id']);
Storage::put('bot_token.dat', $response['bot']['bot_access_token']);
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
      'code' => $code]]);
      $response=json_decode($response->getBody(), true);
      if($response['ok']===true)
      {
        if(isset($response['access_token']))
        {
          $access_token=$response['access_token'];
          $slackUsers = $this->getUserFromToken($access_token);
          $teamName = $slackUsers['team']['name'];

          $this->redirect('/links/{$teamName}');
        }
        else
        {
            $errorMsg=$response['error'];
        }
        return view('authorize', ['result' => $errorMsg]);
      }
    }

    /* Get User details from slack generated token */

    public function getUserFromToken($token);
    {
      $options = ['headers' => ['Accept' => 'application/json']];
      $endpoint = 'https://slack.com/api/users.identity?token='.$token;
      $response = $this->getHttpClient()->get($endpoint, $options)->getBody()->getContents();

      return json_decode($response, true);
    }
}
