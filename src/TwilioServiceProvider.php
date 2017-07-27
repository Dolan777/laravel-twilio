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
            __DIR__ . '/Config/config.php' => config_path('twilio.php'),
                ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        App::bind('twilio', function() {
            return new Twilio;
        });
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'twilio');
    }

}
