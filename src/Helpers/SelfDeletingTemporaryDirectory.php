<?php

namespace Spekulatius\LaravelPowertools\Helpers;

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Spekulatius\LaravelPowertools\Jobs\TemporaryDirectoryCleanupJob;

class SelfDeletingTemporaryDirectory extends TemporaryDirectory
{
    public function create(): TemporaryDirectory
    {
        $instance = parent::create();

        TemporaryDirectoryCleanupJob::dispatch($instance)
            ->delay(now()->addMinutes((int) config('powertools.temporary_directory_clean_up')));

        return $instance;
    }
}
