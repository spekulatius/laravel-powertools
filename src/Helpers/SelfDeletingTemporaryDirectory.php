<?php

namespace Spekulatius\LaravelPowertools\Helpers;

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Spekulatius\LaravelPowertools\Jobs\TemporaryDirectoryCleanupJob;

class SelfDeletingTemporaryDirectory extends TemporaryDirectory
{
    public function __construct(string $location = '')
    {
        parent::__construct($location);

        TemporaryDirectoryCleanupJob::dispatch($this)
            ->delay(now()->addMinutes((int) config('powertools.temporary_directory_clean_up')));
    }
}
