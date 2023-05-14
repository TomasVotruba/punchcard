<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Comment\Doc;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Return_;

final class ServiceConfigStmtsFactory
{
    public function createServiceClassMethod(): ClassMethod
    {
        $parametersVariable = new Variable('parameters');

        $serviceClassMethod = new ClassMethod('service');
        $serviceClassMethod->flags |= Class_::MODIFIER_PUBLIC;
        $serviceClassMethod->returnType = new Identifier('self');
        $serviceClassMethod->params[] = new Param($parametersVariable, null, new Identifier('array'));

        $thisParametersPropertyFetch = new PropertyFetch(new Variable('this'), 'parameters');

        $args = [
            new Arg($thisParametersPropertyFetch),
            new Arg($parametersVariable),
        ];

        $arrayMergeFuncCall = new FuncCall(new Name('array_merge'), $args);

        $serviceClassMethod->stmts[] = new Expression(new Assign($thisParametersPropertyFetch, $arrayMergeFuncCall));
        $serviceClassMethod->stmts[] = new Return_(new Variable('this'));

        return $serviceClassMethod;
    }

    public function createGenericToArrayClassMethod(): ClassMethod
    {
        $toArrayClassMethod = new ClassMethod('toArray');
        $toArrayClassMethod->flags |= Class_::MODIFIER_PUBLIC;
        $toArrayClassMethod->returnType = new Identifier('array');

        $localPropertyFetch = new PropertyFetch(new Variable('this'), 'parameters');
        $toArrayClassMethod->stmts[] = new Return_($localPropertyFetch);

        $toArrayClassMethod->setDocComment(new Doc("/**\n * @return array<string, mixed[]>\n */"));

        return $toArrayClassMethod;
    }

    public function createGenericMakeClassMethod(): ClassMethod
    {
        $new = new New_(new Name('self'));
        $return = new Return_($new);

        return new ClassMethod('make', [
            'flags' => Class_::MODIFIER_PUBLIC | Class_::MODIFIER_STATIC,
            'stmts' => [$return],
            'returnType' => new Name('self'),
        ]);
    }

    public function createParametersProperty(): Property
    {
        $parametersPropertyProperty = new PropertyProperty('parameters', new Array_([]));

        return new Property(
            Class_::MODIFIER_PRIVATE,
            [$parametersPropertyProperty],
            [],
            new Identifier('array')
        );
    }
}
