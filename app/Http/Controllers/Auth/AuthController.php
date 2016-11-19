<?php

  namespace App\Http\Controllers\Auth;

  use Socialite;

  class AuthController extends Controller
  {
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
       $user = Socialite::driver('slack')->user();
   }

  }



?>
