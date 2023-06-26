<?php

namespace Spekulatius\LaravelPowertools\Helpers;

use Spatie\TemporaryDirectory\TemporaryDirectory;
use Spekulatius\LaravelPowertools\Jobs\TemporaryDirectoryCleanupJob;

class SelfDeletingTemporaryDirectory extends TemporaryDirectory
{
    protected bool $previouslyScheduled = false;

    // We hook into the commonly used `path`-method.
    public function path(string $pathOrFilename = ''): string
    {
        if (! $this->previouslyScheduled) {
            TemporaryDirectoryCleanupJob::dispatch($this)
                ->delay(now()->addMinutes((int) config('powertools.temporary_directory_clean_up')));

            $this->previouslyScheduled = true;
        }

        return parent::path($pathOrFilename);
    }
}
