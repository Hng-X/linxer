<?php
  namespace App\Providers;

  use app\Socialite\Socialite;
  use Laravel\Socialite\SocialiteServiceProvider as SocialiteParentServiceProvider;

  class SocialiteServiceProvider extends SocialiteParentServiceProvider
  {
    public function register()
     {
         $this->app->singleton('Laravel\Socialite\Contracts\Factory', function($app) {
             return new Socialite($app);
         });
     }
  }

?>
