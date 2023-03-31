<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use TomasVotruba\PunchCard\ValueObject\ParameterTypeAndDefaultValue;

final class DefaultsClassMethodFactory
{
    /**
     * @param ParameterTypeAndDefaultValue[] $parameterTypeAndDefaultValues
     */
    public function createDefaultsClassMethod(array $parameterTypeAndDefaultValues): ClassMethod
    {
        $stmts = [];

        foreach ($parameterTypeAndDefaultValues as $parameterTypeAndDefaultValue) {
            $defaultMethodCall = new MethodCall(new Variable('this'), $parameterTypeAndDefaultValue->getVariableName(), [
                new Arg($parameterTypeAndDefaultValue->getDefaultValueExpr()),
            ]);

            $stmts[] = new Expression($defaultMethodCall);
        }

        $stmts[] = new Return_(new Variable('this'));

        return new ClassMethod('defaults', [
            'flags' => Class_::MODIFIER_PUBLIC,
            'stmts' => $stmts,
            'returnType' => new Name('self'),
        ]);
    }
}
