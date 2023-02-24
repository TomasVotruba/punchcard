<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Console\Commands;

use Illuminate\Console\Command;

final class PunchCardCommand extends Command
{
    /**
     * @see https://laravel.com/docs/10.x/artisan#input-arrays
     * @var string
     */
    public $signature = 'generate {paths}';

    /**
     * @var string
     */
    public $description = 'Generate fluent config';

    public function handle(): int
    {
        // generate fluent config classes
        $paths = $this->argument('paths');

        dump($paths);
        die;

        $this->comment('All done');

        return self::SUCCESS;
    }
}
