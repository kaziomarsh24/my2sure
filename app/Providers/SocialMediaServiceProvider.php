<?php

namespace App\Providers;

use App\slider;
use Facade\FlareClient\View;
use Illuminate\Support\ServiceProvider;
use App\SocialMediaLink;
use App\User;


class SocialMediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $socialMediaLinks = SocialMediaLink::first();
        $users = User::all();
        $socialMediaLinks->total_users=count($users);


        \Illuminate\Support\Facades\View::share('socialMediaLinks', $socialMediaLinks);
    }

}
