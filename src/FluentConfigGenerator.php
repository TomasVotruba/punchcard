<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Return_;
use TomasVotruba\PunchCard\Enum\ScalarType;
use TomasVotruba\PunchCard\Exception\NotImplementedYetException;
use TomasVotruba\PunchCard\NodeFactory\ConfigClassFactory;
use TomasVotruba\PunchCard\PhpParser\PhpNodesPrinter;
use TomasVotruba\PunchCard\PhpParser\StrictPhpParser;
use TomasVotruba\PunchCard\ValueObject\ParameterAndType;
use Webmozart\Assert\Assert;

/**
 * @api
 */
final class FluentConfigGenerator
{
    public function __construct(
        private readonly ConfigClassFactory $configClassFactory,
        private readonly StrictPhpParser $strictPhpParser,
        private readonly PhpNodesPrinter $phpNodesPrinter,
    ) {
    }

    public function generate(string $configFileContents, string $fileName): ?string
    {
        $configStmts = $this->strictPhpParser->parse($configFileContents);

        $parametersAndTypes = $this->resolveMainParameterNames($configStmts);
        if ($parametersAndTypes === []) {
            return null;
        }

        // create basic class from this one :)
        $class = $this->configClassFactory->createClassFromParameterNames($parametersAndTypes, $fileName);
        return $this->phpNodesPrinter->prettyPrintFile([$class]) . PHP_EOL;
    }

    /**
     * @param Stmt[] $configStmts
     * @return ParameterAndType[]
     */
    private function resolveMainParameterNames(array $configStmts): array
    {
        $parametersAndTypes = [];

        /** @var Stmt[] $configStmts */
        foreach ($configStmts as $configStmt) {
            if (! $configStmt instanceof Return_) {
                continue;
            }

            if (! $configStmt->expr instanceof Array_) {
                continue;
            }

            /** @var Array_ $configArray */
            $configArray = $configStmt->expr;

            foreach ($configArray->items as $arrayItem) {
                Assert::isInstanceOf($arrayItem, ArrayItem::class);

                // collect keys and value types :)
                if (! $arrayItem->key instanceof String_) {
                    continue;
                }

                $parameterName = $arrayItem->key->value;

                // how to resolve type here?
                $scalarType = $this->resolveScalarType($arrayItem);

                $parametersAndTypes[] = new ParameterAndType($parameterName, $scalarType);
            }
        }

        return $parametersAndTypes;
    }

    /**
     * @return ScalarType::*
     */
    private function resolveScalarType(ArrayItem $arrayItem): string
    {
        if ($arrayItem->value instanceof Array_) {
            return ScalarType::ARRAY;
        }

        throw new NotImplementedYetException(
            sprintf('The "%s" type is not implemented yet', $arrayItem->value::class)
        );
    }
}
