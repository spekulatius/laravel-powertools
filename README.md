# A personal collection of Laravel Helpers, my powertools.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spekulatius/laravel-powertools.svg?style=flat-square)](https://packagist.org/packages/spekulatius/laravel-powertools)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spekulatius/laravel-powertools/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spekulatius/laravel-powertools/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/spekulatius/laravel-powertools/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/spekulatius/laravel-powertools/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spekulatius/laravel-powertools.svg?style=flat-square)](https://packagist.org/packages/spekulatius/laravel-powertools)

This is a personal collection of stuff I used across Laravel projects. Handy helpers, tools, utils, etc.

## Features

### ToLog

A simple trait for models to summarize the model-data as logging context. Imagine it like a slimmed down `->toArray()`. It's intended to be used similar to `\Log::error('....', $entry->toLog());`


### Model Tracker

Track (Log) changes to any properties on Models. Supports JSON/array queries. Configured, not coded.

0. Start by exporting the configuration (`php artisan vendor:publish --tag="laravel-powertools-config"`), if you haven't done before.

1. Now you configure any models to track with parameters in `config/powertools.php`:

```php
// in `config/powertools.php`:
return [
    // ...

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

    'model-tracker' => [
        // Disabled by default: Either enable it using the .env key or set it to true here.
        'enabled' => env('APP_MODEL_TRACKER', false),

        // Models to track
        \App\Models\Users::class => [
            'name',
            'email',         // Email isn't changed often. Let's keep an eye on this event.
            'password',      // Fields like this are automatically masked: [masked]

            // It can also access JSON values and track these:
            'custom_permissions.group_slug',
        ],
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

```php
// Changing the password will not log the password:
$user = User::find(1234);
$user->update(['password' => 'some_password']);
$user->save();

// Will log:
// production.INFO: User #1234 (Update): {"password_old": "[masked]", "password_new": "[masked]"}
```

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
return [
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

    'model-tracker' => [
        // \App\Models\Users::class => [
        //     'name',
        //     'email',         // Email isn't changed often. Let's keep an eye on this event.
        //     'password',      // Fields like this are automatically masked
        // ],
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
