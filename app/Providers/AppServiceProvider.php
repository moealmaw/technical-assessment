<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Offers\OffersInterface::class,
            \App\Offers\Expedia\ExpediaApi::class
        );

        $client = new \GuzzleHttp\Client([
            'cookies'  => new \GuzzleHttp\Cookie\FileCookieJar('/tmp/expedia_cookie_new', true),
            'headers'  => [
                'user-agent'      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36",
                'accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'accept-encoding' => 'gzip, deflate, br',
                'accept-language' => 'en-GB,en;q=0.9,en-US;q=0.8,ar;q=0.7',
            ],
        ]);

        $this->app->instance(\GuzzleHttp\Client::class, $client);
    }
}
