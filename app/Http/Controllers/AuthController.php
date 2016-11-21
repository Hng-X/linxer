<?php

namespace App\Http\Controllers;

use Socialite;

class AuthController extends Controller
{

    public function authorize()
    {
        return view('authorize');
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
