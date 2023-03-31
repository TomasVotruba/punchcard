<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;

final class MakeClassMethodFactory
{
    public function create(): ClassMethod
    {
        $classMethod = new ClassMethod('make');
        $classMethod->flags |= Class_::MODIFIER_STATIC;
        $classMethod->flags |= Class_::MODIFIER_PUBLIC;
        $classMethod->returnType = new Name('self');

        $newSelfReturn = new Return_(new New_(new Name('self')));

        $classMethod->stmts = [$newSelfReturn];

        return $classMethod;
    }
}
