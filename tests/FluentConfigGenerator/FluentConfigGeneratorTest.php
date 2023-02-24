<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Tests\FluentConfigGenerator;

use Nette\Utils\FileSystem;
use TomasVotruba\PunchCard\FluentConfigGenerator;
use TomasVotruba\PunchCard\Tests\AbstractTestCase;

final class FluentConfigGeneratorTest extends AbstractTestCase
{
    private FluentConfigGenerator $fluentConfigGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fluentConfigGenerator = app()->make(FluentConfigGenerator::class);
    }

    public function test(): void
    {
        /** @var string[] $fixtureFilesPaths */
        $fixtureFilesPaths = glob(__DIR__ . '/Fixture/*.php.inc');

        foreach ($fixtureFilesPaths as $fixtureFilePath) {
            $fixtureFileContents = FileSystem::read($fixtureFilePath);

            [$inputConfigContents, $expectedConfigClassContents] = $this->split($fixtureFileContents);

            $configClassContents = $this->fluentConfigGenerator->generate($inputConfigContents, $fixtureFilePath);

            $this->assertSame($expectedConfigClassContents, $configClassContents);
        }
    }

    /**
     * @return array{string, string}
     */
    private function split(string $fileContents): array
    {
        $parts = str($fileContents)->split('#\-\-\-\-\-\n#');
        return [$parts[0], $parts[1]];
    }
}
