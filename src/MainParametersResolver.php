<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Return_;
use TomasVotruba\PunchCard\Contracts\TypeInterface;
use TomasVotruba\PunchCard\ValueObject\ConfigFile;
use TomasVotruba\PunchCard\ValueObject\ParameterTypeAndDefaultValue;
use TomasVotruba\PunchCard\ValueObject\Types\StringType;
use Webmozart\Assert\Assert;

final class MainParametersResolver
{
    public function __construct(
        private readonly ParameterTypeResolver $parameterTypeResolver,
    ) {
    }

    /**
     * @param Stmt[] $configStmts
     * @return ParameterTypeAndDefaultValue[]
     */
    public function resolveMainParameters(array $configStmts, ConfigFile $configFile): array
    {
        $parameterTypeAndDefaultValues = [];

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

                $propertyType = KnownTypesMap::match($configFile->getShortFileName(), $parameterName) ?? null;

                // how to resolve type here?
                if (! $propertyType instanceof TypeInterface) {
                    $propertyType = $this->parameterTypeResolver->resolveFromExpr($arrayItem->value, $parameterName, $configFile);
                    $paramSetterType = $propertyType;

                    // make always nullable, as does not have to be set
                    if ($propertyType instanceof StringType) {
                        $propertyType = new StringType(true);
                    }
                } else {
                    $paramSetterType = $propertyType;
                }

                $defaultValueExpr = $arrayItem->value;

                $comments = $arrayItem->getComments();
                $parameterTypeAndDefaultValues[] = new ParameterTypeAndDefaultValue($parameterName, $propertyType, $paramSetterType, $comments, $defaultValueExpr);
            }
        }

        return $parameterTypeAndDefaultValues;
    }
}
