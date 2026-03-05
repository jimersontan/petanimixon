<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use current request URL for links/assets when testing on mobile/network
        if (app()->environment('local') && request()->server('HTTP_HOST')) {
            $host = request()->getHost();
            $port = request()->getPort();
            $scheme = request()->getScheme();
            if ($host && $host !== 'localhost' && $host !== '127.0.0.1') {
                $root = $scheme . '://' . $host . (in_array($port, [80, 443]) ? '' : ':' . $port);
                URL::forceRootUrl($root);
            }
        }
    }
}
