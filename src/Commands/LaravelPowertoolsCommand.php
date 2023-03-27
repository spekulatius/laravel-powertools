<?php

namespace Spekulatius\LaravelPowertools\Commands;

use Illuminate\Console\Command;

class LaravelPowertoolsCommand extends Command
{
    public $signature = 'laravel-powertools';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
