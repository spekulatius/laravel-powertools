<?php

namespace Spekulatius\LaravelPowertools\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spekulatius\LaravelPowertools\Helpers\SelfDeletingTemporaryDirectory;

class TemporaryDirectoryCleanupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected SelfDeletingTemporaryDirectory $selfDeletingTemporaryDirectory
    ) {
    }

    public function handle(): void
    {
        try {
            $this->selfDeletingTemporaryDirectory->delete();
        } catch (\Exception $e) {
            Log::error('SelfDeletingTemporaryDirectory: Failed to delete temp dir: '.$e->getMessage(), [
                'path' => $this->selfDeletingTemporaryDirectory->path(),
            ]);

            throw $e;
        }
    }
}
