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
use TomasVotruba\PunchCard\ValueObject\ParameterTypeAndDefaultValue;
use TomasVotruba\PunchCard\ValueObject\Types\ArrayType;

final class SetterClassMethodFactory
{
    public function create(ParameterTypeAndDefaultValue $parameterTypeAndDefaultValue): ClassMethod
    {
        $classMethod = new ClassMethod($parameterTypeAndDefaultValue->getVariableName());
        $classMethod->flags |= Class_::MODIFIER_PUBLIC;
        $classMethod->returnType = new Name('self');

        $param = $this->createParam($parameterTypeAndDefaultValue);

        $classMethod->params[] = $param;
        $classMethod->stmts = $this->createClassMethodStmts($parameterTypeAndDefaultValue);

        // move descirptive comments first
        $classMethod->setAttribute('comments', $parameterTypeAndDefaultValue->getComments());

        $this->decorateDocBlock($classMethod, $parameterTypeAndDefaultValue);

        return $classMethod;
    }

    /**
     * @return Stmt[]
     */
    private function createClassMethodStmts(ParameterTypeAndDefaultValue $parameterTypeAndDefaultValue): array
    {
        $propertyFetch = new PropertyFetch(new Variable('this'), $parameterTypeAndDefaultValue->getVariableName());
        $propertyAssign = new Assign($propertyFetch, new Variable($parameterTypeAndDefaultValue->getVariableName()));

        $return = new Return_(new Variable('this'));

        return [new Expression($propertyAssign), $return];
    }

    private function createParam(ParameterTypeAndDefaultValue $parameterTypeAndDefaultValue): Param
    {
        $param = new Param(new Variable($parameterTypeAndDefaultValue->getVariableName()));
        $param->type = new Identifier($parameterTypeAndDefaultValue->getSetterParamTypeDeclaration());

        return $param;
    }

    private function decorateDocBlock(ClassMethod $classMethod, ParameterTypeAndDefaultValue $parameterTypeAndDefaultValue): void
    {
        if (! $parameterTypeAndDefaultValue->getSetterParamType() instanceof ArrayType) {
            return;
        }

        $classMethod->setDocComment(new Doc(sprintf(
            "/**\n * @param %s $%s\n */",
            $parameterTypeAndDefaultValue->renderPropertyTypeDoc(),
            $parameterTypeAndDefaultValue->getName()
        )));
    }
}
