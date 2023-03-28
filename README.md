# A personal collection of Laravel Helpers, my powertools.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spekulatius/laravel-powertools.svg?style=flat-square)](https://packagist.org/packages/spekulatius/laravel-powertools)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spekulatius/laravel-powertools/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spekulatius/laravel-powertools/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/spekulatius/laravel-powertools/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/spekulatius/laravel-powertools/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spekulatius/laravel-powertools.svg?style=flat-square)](https://packagist.org/packages/spekulatius/laravel-powertools)

This is a personal collection of stuff I used across Laravel projects. Handy helpers, tools, utils, etc.

## Features

### ToLog

A simple trait for models to summarize the model-data as logging context. Imagine it like a slimmed down `->toArray()`. It's intended to be used similar to `\Log::error('....', $entry->toLog());`

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

You can publish the config file with:

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
