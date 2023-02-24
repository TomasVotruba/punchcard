<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use TomasVotruba\PunchCard\Enum\ScalarType;
use TomasVotruba\PunchCard\ValueObject\ParameterAndType;

final class SetterClassMethodFactory
{
    public function create(ParameterAndType $parameterAndType): ClassMethod
    {
        $classMethod = new ClassMethod($parameterAndType->getName());
        $classMethod->flags |= Class_::MODIFIER_PUBLIC;
        $classMethod->returnType = new Name('self');

        $param = $this->createParam($parameterAndType);

        $classMethod->params[] = $param;
        $classMethod->stmts = $this->createClassMethodStmts($parameterAndType);

        $this->decorateDocBlock($classMethod, $parameterAndType);

        return $classMethod;
    }

    /**
     * @return Stmt[]
     */
    private function createClassMethodStmts(ParameterAndType $parameterAndType): array
    {
        $propertyFetch = new PropertyFetch(new Variable('this'), $parameterAndType->getName());
        $propertyAssign = new Assign($propertyFetch, new Variable($parameterAndType->getName()));

        $return = new Return_(new Variable('this'));

        return [new Expression($propertyAssign), $return];
    }

    private function createParam(ParameterAndType $parameterAndType): Param
    {
        $param = new Param(new Variable($parameterAndType->getName()));
        $param->type = new Identifier($parameterAndType->getType());

        return $param;
    }

    private function decorateDocBlock(ClassMethod $classMethod, ParameterAndType $parameterAndType): void
    {
        // add docblocks
        if ($parameterAndType->getType() === ScalarType::ARRAY) {
            $classMethod->setDocComment(new Doc("/**\n * @param string[] $" . $parameterAndType->getName() . "\n */"));
        }
    }
}
