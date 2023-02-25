<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Commands;

use Throwable;
use Illuminate\Console\Command;
use Nette\Utils\FileSystem;
use TomasVotruba\PunchCard\FluentConfigGenerator;
use Webmozart\Assert\Assert;

final class PunchCardCommand extends Command
{
    /**
     * @see https://laravel.com/docs/10.x/artisan#input-arrays
     * @var string
     */
    public $signature = 'app:generate {paths*} {--output=}';

    /**
     * @var string
     */
    public $description = 'Generate fluent config';

    public function __construct(
        private readonly FluentConfigGenerator $fluentConfigGenerator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        /** @var string[] $paths */
        $paths = $this->argument('paths');

        // normalize to files
        $filePaths = $this->normalizeToFiles($paths);

        foreach ($filePaths as $filePath) {
            $fileContents = FileSystem::read($filePath);

            try {
                $fluentConfigContents = $this->fluentConfigGenerator->generate($fileContents, $filePath);
            } catch (Throwable $throwable) {
                $errorMessage = sprintf('Not implemented yet for %s: %s', $filePath, $throwable->getMessage());
                $this->error($errorMessage);
                return self::FAILURE;
            }

            $outputDirectory = $this->option('output');
            if (is_string($outputDirectory)) {
                $outputFilePath = $this->resolveOutputFilePath($fluentConfigContents, $outputDirectory);
                FileSystem::write($outputFilePath, $fluentConfigContents);

                $this->line(sprintf('File was generated to "%s"', $outputFilePath));
            } else {
                $this->line(sprintf('Generated config contents: "%s"', PHP_EOL . PHP_EOL . $fluentConfigContents));
            }
        }

        $this->newLine();
        $this->info('Generating finished');

        return self::SUCCESS;
    }

    private function resolveOutputFilePath(string $fluentConfigContents, string $outputDirectory): string
    {
        // generate to file path
        $shortClassName = str($fluentConfigContents)
            ->match('#class (\w+)#')
            ->value();

        Assert::notEmpty($shortClassName);

        return $outputDirectory . '/' . $shortClassName . '.php';
    }

    /**
     * @param string[] $paths
     * @return string[]
     */
    private function normalizeToFiles(array $paths): array
    {
        $filePaths = [];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $currentFilePaths = glob($path . '/*.php', GLOB_BRACE);
                if (! is_array($currentFilePaths)) {
                    continue;
                }

                $filePaths = [...$filePaths, ...$currentFilePaths];
            } else {
                $filePaths[] = $path;
            }
        }

        Assert::allString($filePaths);

        return $filePaths;
    }
}
