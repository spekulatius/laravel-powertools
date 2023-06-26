<?php

namespace Spekulatius\LaravelPowertools\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class TemporaryDirectoryCleanupJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected TemporaryDirectory $temporaryDirectory
    ) {
    }

    public function handle(): void
    {
        try {
            $this->temporaryDirectory->delete();
        } catch (\Exception $e) {
            Log::error('SelfDeletingTemporaryDirectory: Failed to delete temp dir: '.$e->getMessage(), [
                'path' => $this->temporaryDirectory->path(),
            ]);

            throw $e;
        }
    }

    // Tell Laravel how to determine the difference between unique jobs here.
    public function uniqueId(): string
    {
        return $this->temporaryDirectory->path();
    }
}
