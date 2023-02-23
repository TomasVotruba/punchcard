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
use TomasVotruba\PunchCard\ValueObject\ParameterAndType;

final class ToArrayClassMethodFactory
{
    /**
     * @param ParameterAndType[] $parametersAndTypes
     */
    public function create(array $parametersAndTypes): ClassMethod
    {
        $toArrayClassMethod = new ClassMethod('toArray');
        $toArrayClassMethod->flags |= Class_::MODIFIER_PUBLIC;
        $toArrayClassMethod->returnType = new Identifier('array');

        $array = new Array_();
        foreach ($parametersAndTypes as $parameterAndType) {
            $array->items[] = new ArrayItem(
                new PropertyFetch(new Variable('this'), $parameterAndType->getName()),
                new String_($parameterAndType->getName())
            );
        }

        $toArrayClassMethod->stmts[] = new Return_($array);

        $toArrayClassMethod->setDocComment(new Doc("/**\n * @return array<string, mixed[]>\n */"));

        return $toArrayClassMethod;
    }
}
