<?php

namespace TomasVotruba\PunchCard\Tests\FluentConfigGenerator;

use PHPUnit\Framework\TestCase;
use TomasVotruba\PunchCard\FluentConfigGenerator;

final class FluentConfigGeneratorTest extends TestCase
{
    private FluentConfigGenerator $fluentConfigGenerator;

    protected function setUp(): void
    {
        $this->fluentConfigGenerator = new FluentConfigGenerator();
    }

    public function test(): void
    {
        $fixtureFilesPaths = glob(__DIR__ . '/Fixture/*.php.inc');
        foreach ($fixtureFilesPaths as $fixtureFilePath) {
            $fixtureFileContents = file_get_contents($fixtureFilePath);

            $parts = str($fixtureFileContents)->split('#\-\-\-\-\-#');

            $inputConfigContents = $parts[0];
            $expectedConfigClassContents = $parts[1];

            $configClassContents = $this->fluentConfigGenerator->generate($inputConfigContents);

            $this->assertSame($expectedConfigClassContents, $configClassContents);
        }
    }
}
