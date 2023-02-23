<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Commands;

use Illuminate\Console\Command;

final class PunchCardCommand extends Command
{
    public $signature = 'punchcard';

    public $description = 'My command';

    public function handle(): int
    {
        // generate fluent config classes

        $this->comment('All done');

        return self::SUCCESS;
    }
}
