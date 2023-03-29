<?php

namespace Spekulatius\LaravelPowertools;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spekulatius\LaravelPowertools\Commands\LaravelPowertoolsCommand;
use Spekulatius\LaravelPowertools\Observers\ModelTrackerObserver;

class LaravelPowertoolsServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        // Model Tracker: We should automatically track any property changes on these models.
        foreach (config('powertools.model_tracker.models', []) as $model => $attributes) {
            $model::observe(ModelTrackerObserver::class);
        }
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
