<?php

namespace App\Http\Controllers;

use Socialite;
use Storage;
use GuzzleHttp\Client;

class AuthController extends Controller
{

    public function authorize()
    {  
        if(isset($_GET['code']) {
             $code=$_GET['code'];
             $client=new Client();
             $response=$client->request('POST', 'https://slack.com/api/oauth.access',
['json' => ['client_id' => env('SLACK_CLIENT_ID'),
'client_secret' => env('SLACK_CLIENT_SECRET'),
'code' => $code]]);
$response=json_decode($response->getBody(), true);
if($response['ok']==true) {
if(isset($response['access_token'])) {
Storage::put('token.dat', $response['access_token']);
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
    }


    /* Redirects user to Slack Authetication page
    *
    * @return Response
    */

    public function redirectToProvider()
    {
       return Socialite::driver('slack')->redirect();
    }

    /**
    * Obtain the user information from Slack.
    *
    * @return Response
    */
   public function handleProviderCallback()
   {
       // $user = Socialite::driver('slack')->user();
       $user = Socialite::with('slack')->user();
       var_dump($user);
   }
}
