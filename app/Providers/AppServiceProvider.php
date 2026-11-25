<?php

namespace App\Providers;

use App\setting;
use App\slider;
use App\SocialMediaLink;
use App\User;
use Illuminate\Support\Facades\Cache;
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
            return Cache::remember('global_settings', 600, fn () => setting::get());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $objSliders = Cache::remember('global_sliders', 600, function () {
                return Slider::all()->toArray();
            });

            $users = Cache::remember('total_users_count', 300, function () {
                return User::count();
            });

            $settings = Cache::remember('global_settings', 600, function () {
                return setting::get();
            });

            View::share('objSliders', $objSliders);
            View::share('users', $users);
            View::share('settings', $settings);
        } catch (\Throwable $e) {
            // Skip if database is not yet available during CLI bootstrap
        }
    }
}
