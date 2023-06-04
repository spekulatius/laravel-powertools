# A personal collection of Laravel Helpers, my powertools.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spekulatius/laravel-powertools.svg?style=flat-square)](https://packagist.org/packages/spekulatius/laravel-powertools)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spekulatius/laravel-powertools/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spekulatius/laravel-powertools/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/spekulatius/laravel-powertools/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/spekulatius/laravel-powertools/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spekulatius/laravel-powertools.svg?style=flat-square)](https://packagist.org/packages/spekulatius/laravel-powertools)

This is a personal collection of handy helpers, tools, and utilities that I've used across various Laravel projects. However, please note that these are intended for personal use and development, so please use at your own risk.

## Toolbox

### `maskSensitiveData`: Collection Makro to mask sensitive data

`maskSensitiveData` Laravel Collection macro and provides the functionality to mask sensitive data in a collection. The macro prepares masked fields regular expressions for use, and applies the mask to the sensitive data based on the regexes and custom fields. It maps over the collection and replaces any data matching the regular expressions with a mask value of `[masked]`. This functionality is useful when dealing with collections of sensitive data and is designed to keep the sensitive data secure.

Usage:

```php
collect(['password' => 'this really should not be logged...'])
  ->maskSensitiveData()
  ->toArray();

// 'password' => '[masked]'
```

### `ToLog`: Model Trait to log context

The `ToLog` trait is a simple trait to add to models that allows you to summarize model data as logging context. It's essentially a slimmed-down version of the `->toArray()` method, and it's meant to be used in a similar approach similar to `\Log::error('....', $entry->toLog());`. Already runs `maskSensitiveData` by design.

## Compatibility

This project has been tested on Laravel 10 using PHP 8.1 or 8.2. It should work on Laravel 9 as well, although it has not been tested on that version.

#### Requirements

For the standard-usable, you'll need no additional requirements. If you'd like to customerize the "\[masked\]"-util, feel free to export the config as described under [Installation](#Installation).
Requirements: None.

### Model Tracker

Track (Log) changes to any properties on Models. Supports JSON/array queries. Configured, not coded.

#### Requirements

- Start by exporting the configuration (`php artisan vendor:publish --tag="laravel-powertools-config"`), if you haven't done before.

- Enable it by including `APP_MODEL_TRACKER=true` in your `.env` file.

#### Configuration

You can configure any models to track with parameters in `config/powertools.php`:

```php
// in `config/powertools.php`:

    'model_tracker' => [
        // Disabled by default: Either enable it using the .env key or set it to true here.
        'enabled' => env('APP_MODEL_TRACKER', false),

        // Models to track
        'models' => [
            // \App\Models\Users::class => [
            //     'name',
            //     'email',         // Email isn't changed often. Let's keep an eye on this event.
            //     'password',      // Fields like this are automatically masked
            // ],
        ],

    // ...
];
```

#### Example 1: Keep an eye on critical properties

The Model Tracker can assist in keeping an eye on business or security-critical parameters as an additional layer of protection.

```php
// Change the email address and save.
$user = User::find(1234);
$user->email = 'new@email.com';
$user->save();

// Will log:
// production.INFO: User #1234 (Update): {"email_old": "old@email.com", "email_new": "new@email.com"}
```

#### Example 2: Masking Senisible Fields/data.

You can define some fields to be `[masked]` in the data:

```php
// Changing the password will not log the password:
$user = User::find(1234);
$user->update(['password' => 'some_password']);
$user->save();

// Will log:
// production.INFO: User #1234 (Update): {"password_old": "[masked]", "password_new": "[masked]"}
```

You can adjust the list of masked properties in the config-fil under `masked_fields`.


## Installation

You can install the package via composer:

```bash
composer require spekulatius/laravel-powertools
```

<!--
You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-powertools-migrations"
php artisan migrate
```
-->

Some tools require configuration:

```bash
php artisan vendor:publish --tag="laravel-powertools-config"
```

This is the contents of the published config file:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Masked fields
    |--------------------------------------------------------------------------
    |
    | These properties will be replaced with "[masked]",
    |   when logged via toLog or the model tracker.
    |
    */

    'masked_fields' => [
        '/password/i',
        '/passwd/i',
        '/hash/i',
        '/checksum/i',
        '/salt/i',
        '/token/i',
        '/key/i',
        '/secret/i',
        '/acl/i',
    ],

    /*
    |--------------------------------------------------------------------------
    | Model (Property) Tracker
    |--------------------------------------------------------------------------
    |
    | These properties will be logged when changed.
    |
    | It hooks the Observer automatically in, when listed here.
    |
    */

    'model_tracker' => [
        // Disabled by default: Either enable it using the .env key or set it to true here.
        'enabled' => env('APP_MODEL_TRACKER', false),

        // Models to track
        'models' => [
            // \App\Models\Users::class => [
            //     'name',
            //     'email',         // Email isn't changed often. Let's keep an eye on this event.
            //     'password',      // Fields like this are automatically masked
            // ],
        ],
    ],

];
```

<!--
Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-powertools-views"
```

## Usage

```php
$laravelPowertools = new Spekulatius\LaravelPowertools();
echo $laravelPowertools->echoPhrase('Hello, Spekulatius!');
```
-->

## Testing

The project is roughly tested on Laravel 10.

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Peter Thaleikis](https://github.com/spekulatius)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
