<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;
use TomasVotruba\PunchCard\NodeFactory\ConfigClassFactory;
use TomasVotruba\PunchCard\PhpParser\PhpNodesPrinter;
use TomasVotruba\PunchCard\PhpParser\StrictPhpParser;
use TomasVotruba\PunchCard\ValueObject\ConfigFile;

/**
 * @api
 */
final class FluentConfigGenerator
{
    /**
     * @var string
     */
    private const NAMESPACE_NAME = 'TomasVotruba\PunchCard';

    public function __construct(
        private readonly ConfigClassFactory $configClassFactory,
        private readonly StrictPhpParser $strictPhpParser,
        private readonly PhpNodesPrinter $phpNodesPrinter,
        private readonly MainParametersResolver $mainParametersResolver,
    ) {
    }

    public function generate(ConfigFile $configFile): string
    {
        $configStmts = $this->strictPhpParser->parse($configFile->getFileContents());

        $parameterTypeAndDefaultValues = $this->mainParametersResolver->resolveMainParameters($configStmts, $configFile);
        if ($parameterTypeAndDefaultValues === []) {
            // empty config
            return '';
        }

        // create basic class from this one :)
        $class = $this->configClassFactory->createClassFromParameterNames($parameterTypeAndDefaultValues, $configFile);

        $namespace = new Namespace_(new Name(self::NAMESPACE_NAME), [
            $class,
        ]);

        return $this->phpNodesPrinter->prettyPrintFile([$namespace]) . PHP_EOL;
    }
}
