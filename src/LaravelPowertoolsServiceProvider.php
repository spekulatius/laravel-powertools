<?php

namespace Spekulatius\LaravelPowertools;

use Illuminate\Support\Collection;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spekulatius\LaravelPowertools\Commands\LaravelPowertoolsCommand;

class LaravelPowertoolsServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        // Mask some sensitive data in a collection
        Collection::macro('maskSensitiveData', function () {
            // Prepare the masked fields regexes for prime time.
            $regexes = (array) config('powertools.masked_fields', []);

            // Apply the mask to the sensitive data based on the regexes and custom fields
            return $this->map(function ($value, $key) use (&$regexes) {
                // Early return null - masking this won't make any sense...
                if ($value === null) {
                    return null;
                }

                // Check if the key matches one of the regexes
                foreach ($regexes as $regex) {
                    if (preg_match($regex, $key) > 0) {
                        return '[masked]';
                    }
                }

                // Return the original value if it's not sensitive
                return $value;
            });
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-powertools')
            ->hasConfigFile();
        // ->hasViews()
        // ->hasMigration('create_laravel-powertools_table')
        // ->hasCommand(LaravelPowertoolsCommand::class);
    }
}
