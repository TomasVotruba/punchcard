<?php

namespace TomasVotruba\PunchCard\Commands;

use Illuminate\Console\Command;

class PunchCardCommand extends Command
{
    public $signature = 'punchcard';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
