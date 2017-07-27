<?php

namespace Laravelpackage\Twilio;

use App;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('twilio.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'twilio');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include __DIR__ . '/routes.php';
        App::bind('twilio', function() {
            return new Twilio;
        });
    }

}
