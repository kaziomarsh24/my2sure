<?php

namespace App\Providers;

use App\setting;
use App\slider;
use App\SocialMediaLink;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind("objSetting", function($app) {
            $obj = setting::get();
            return $obj;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $objSliders = Slider::all()->toArray();
        $users      = User::all();
        $users      = count($users);

        View::share('objSliders', $objSliders);
        View::share('users', $users);

        // Share settings globally across all views
        View::composer('*', function ($view) {
            if (!$view->offsetExists('settings')) {
                $view->with('settings', setting::get());
            }
        });
    }
}
