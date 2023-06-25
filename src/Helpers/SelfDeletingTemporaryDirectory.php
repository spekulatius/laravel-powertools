<?php

namespace Spekulatius\LaravelPowertools\Helpers;

use Spatie\TemporaryDirectory\TemporaryDirectory;

class SelfDeletingTemporaryDirectory extends TemporaryDirectory
{
    public function __construct(string $location = '')
    {
        parent::__construct($location);

        TemporaryDirectoryCleanupJob::dispatch($this)
            ->delay(config('powertools.temporary_directory_clean_up'));
    }
}
