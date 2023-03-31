<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use TomasVotruba\PunchCard\ValueObject\ParameterTypeAndDefaultValue;

final class ToArrayClassMethodFactory
{
    /**
     * @param ParameterTypeAndDefaultValue[] $parameterTypeAndDefaultValues
     */
    public function create(array $parameterTypeAndDefaultValues): ClassMethod
    {
        $toArrayClassMethod = new ClassMethod('toArray');
        $toArrayClassMethod->flags |= Class_::MODIFIER_PUBLIC;
        $toArrayClassMethod->returnType = new Identifier('array');

        $array = $this->createArray($parameterTypeAndDefaultValues);
        $toArrayClassMethod->stmts[] = new Return_($array);

        $toArrayClassMethod->setDocComment(new Doc("/**\n * @return array<string, mixed[]>\n */"));

        return $toArrayClassMethod;
    }

    /**
     * @param ParameterTypeAndDefaultValue[] $parameterTypeAndDefaultValues
     */
    private function createArray(array $parameterTypeAndDefaultValues): Array_
    {
        $array = new Array_();

        foreach ($parameterTypeAndDefaultValues as $parameterTypeAndDefaultValue) {
            $localPropertyFetch = new PropertyFetch(new Variable('this'), $parameterTypeAndDefaultValue->getVariableName());
            $parameterName = new String_($parameterTypeAndDefaultValue->getName());

            $array->items[] = new ArrayItem($localPropertyFetch, $parameterName);
        }

        return $array;
    }
}
