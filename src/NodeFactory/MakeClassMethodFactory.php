<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;

final class MakeClassMethodFactory
{
    public function create(): ClassMethod
    {
        $classMethod = new ClassMethod('makeWithDefaults');
        $classMethod->flags |= Class_::MODIFIER_STATIC;
        $classMethod->flags |= Class_::MODIFIER_PUBLIC;
        $classMethod->returnType = new Name('self');

        $makeWithDefaultStaticCall = new StaticCall(new Name('self'), 'make');
        $classMethod->stmts = [new Return_($makeWithDefaultStaticCall)];

        $classMethod->setDocComment(new Doc("/**\n * @deprecated Use self::make() with identical behavior\n */"));

        return $classMethod;
    }
}
