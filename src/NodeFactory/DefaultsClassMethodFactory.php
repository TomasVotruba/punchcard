<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
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

        $configVariable = new Variable('config');
        $configToNewSelfAssign = new Assign($configVariable, new New_(new Name('self')));

        $stmts[] = new Expression($configToNewSelfAssign);

        foreach ($parameterTypeAndDefaultValues as $parameterTypeAndDefaultValue) {
            $defaultMethodCall = new MethodCall($configVariable, $parameterTypeAndDefaultValue->getVariableName(), [
                new Arg($parameterTypeAndDefaultValue->getDefaultValueExpr()),
            ]);

            $stmts[] = new Expression($defaultMethodCall);
        }

        $stmts[] = new Return_($configVariable);

        return new ClassMethod('make', [
            'flags' => Class_::MODIFIER_PUBLIC | Class_::MODIFIER_STATIC,
            'stmts' => $stmts,
            'returnType' => new Name('self'),
        ]);
    }
}
