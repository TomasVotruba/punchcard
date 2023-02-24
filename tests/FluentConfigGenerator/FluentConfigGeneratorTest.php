<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Tests\FluentConfigGenerator;

use Nette\Utils\FileSystem;
use PHPUnit\Framework\Attributes\DataProvider;
use TomasVotruba\PunchCard\FluentConfigGenerator;
use TomasVotruba\PunchCard\Tests\AbstractTestCase;

final class FluentConfigGeneratorTest extends AbstractTestCase
{
    private FluentConfigGenerator $fluentConfigGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fluentConfigGenerator = $this->make(FluentConfigGenerator::class);
    }

    #[DataProvider('provideData')]
    public function test(string $fixtureFilePath): void
    {
        $fixtureFileContents = FileSystem::read($fixtureFilePath);

        [$inputConfigContents, $expectedConfigClassContents] = $this->split($fixtureFileContents);

        $configClassContents = $this->fluentConfigGenerator->generate($inputConfigContents, $fixtureFilePath);

        $this->assertSame($expectedConfigClassContents, $configClassContents);
    }

    public static function provideData(): \Iterator
    {
        /** @var string[] $fixtureFilesPaths */
        $fixtureFilesPaths = glob(__DIR__ . '/Fixture/*.php.inc');
        foreach ($fixtureFilesPaths as $fixtureFilesPath) {
            yield [$fixtureFilesPath];
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
