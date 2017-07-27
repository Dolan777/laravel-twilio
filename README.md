laravel-twilio
===============
Laravel Twillio API Integration


## Installation

Begin by installing this package through Composer. Run this command from the Terminal:

```bash
composer require laravelpackage/twilio
```

## Laravel integration

To wire this up in your Laravel project, whether it's built in Laravel  5, you need to add the service provider.
Open `app.php`, and add a new item to the providers array.

```php
 Laravelpackage\Twilio\TwilioServiceProvider::class,
```

This will register two new artisan commands for you:


```php
'Twilio' => Laravelpackage\Twilio\Facades\Twilio::class,
```



In Laravel 5 you can publish the default config file to `config/twilio.php` with the artisan command `vendor:publish`.

#### Facade

The facade has the exact same methods as the `Aloha\Twilio\TwilioInterface`. First, include the `Facade` class at the top of your file:

```php
use Twilio;
```

To send a message using the default entry from your `twilio` [config file](src/config/config.php):


