<?php

namespace Mailchimp;

use Illuminate\Support\ServiceProvider;

class MailchimpServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/mailchimp.php' => config_path('mailchimp.php')
        ]);
    }

    public function register()
    {
        $this->app->bind('Mailchimp\Mailchimp', function ($app) {
            $config = $app['config']['mailchimp'];

            return new Mailchimp($config['apikey']);
        });
    }
}
