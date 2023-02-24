<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Console\Commands;

use Illuminate\Console\Command;
use Nette\Utils\FileSystem;
use TomasVotruba\PunchCard\FluentConfigGenerator;

final class PunchCardCommand extends Command
{
    /**
     * @see https://laravel.com/docs/10.x/artisan#input-arrays
     * @var string
     */
    public $signature = 'app:generate {paths*}';

    /**
     * @var string
     */
    public $description = 'Generate fluent config';

    public function __construct(
        private readonly FluentConfigGenerator $fluentConfigGenerator,
    )
    {
        parent::__construct();
    }

    public function handle(): void
    {
        /** @var string[] $paths */
        $paths = $this->argument('paths');

        foreach ($paths as $path) {
            $fileContents = FileSystem::read($path);

            $fluentConfigContents = $this->fluentConfigGenerator->generate($fileContents, $path);
            dump($fluentConfigContents);
        }

        $this->info('All done');
    }
}
