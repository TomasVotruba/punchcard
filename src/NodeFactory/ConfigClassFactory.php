<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use PhpParser\Builder\Method;
use PhpParser\Builder\Property;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Return_;
use TomasVotruba\PunchCard\Enum\ScalarType;
use TomasVotruba\PunchCard\ValueObject\ParameterAndType;
use Webmozart\Assert\Assert;

final class ConfigClassFactory
{
    /**
     * @param ParameterAndType[] $parameterAndTypes
     */
    public function createClassFromParameterNames(array $parameterAndTypes, string $fileName): Class_
    {
        Assert::allIsInstanceOf($parameterAndTypes, ParameterAndType::class);

        $class = $this->createClass($fileName);

        $properties = $this->createProperties($parameterAndTypes);
        $classMethods = $this->createClassMethods($parameterAndTypes);

        // add static "create" method
        $classMethod = $this->createCreateStaticClassMethod();

        $class->stmts = array_merge($properties, [new Nop()], [$classMethod], $classMethods);

        return $class;
    }

    /**
     * @param ParameterAndType[] $parametersAndTypes
     * @return \PhpParser\Node\Stmt\Property[]
     */
    private function createProperties(array $parametersAndTypes): array
    {
        $properties = [];

        foreach ($parametersAndTypes as $parameterAndType) {
            $propertyBuilder = new Property($parameterAndType->getName());
            $propertyBuilder->makePrivate();
            $propertyBuilder->setType(new Identifier($parameterAndType->getType()));

            if ($parameterAndType->getType() === ScalarType::ARRAY) {
                $propertyBuilder->setDefault(new Array_([]));
            }

            // @todo types and defaults
            $properties[] = $propertyBuilder->getNode();
        }

        return $properties;
    }

    /**
     * @param ParameterAndType[] $parametersAndTypes
     * @return ClassMethod[]
     */
    private function createClassMethods(array $parametersAndTypes): array
    {
        $classMethods = [];

        foreach ($parametersAndTypes as $parameterAndType) {
            $methodBuilder = new Method($parameterAndType->getName());
            $methodBuilder->makePublic();
            $methodBuilder->setReturnType(new Name('self'));

            $param = new Param(new Variable($parameterAndType->getName()));
            $param->type = new Identifier($parameterAndType->getType());
            $methodBuilder->addParam($param);

            $propertyFetch = new PropertyFetch(new Variable('this'), $parameterAndType->getName());
            $propertyAssign = new Assign($propertyFetch, new Variable($parameterAndType->getName()));

            $returnThis = new Return_(new Variable('this'));

            $methodBuilder->addStmts([$propertyAssign, $returnThis]);

            $classMethods[] = $methodBuilder->getNode();
        }

        return $classMethods;
    }

    private function createCreateStaticClassMethod(): ClassMethod
    {
        $classMethod = new ClassMethod('create');
        $classMethod->flags |= Class_::MODIFIER_STATIC;
        $classMethod->flags |= Class_::MODIFIER_PUBLIC;

        $newSelfReturn = new Return_(new New_(new Name('self')));

        $classMethod->stmts = [$newSelfReturn];

        return $classMethod;
    }

    private function createClass(string $fileName): Class_
    {
        $shortFileName = str($fileName)
            ->match('#\/(?<name>[\w]+)\.php#')
            ->value();

        $configClassName = ucfirst(($shortFileName) . 'Config');

        $class = new Class_($configClassName);
        $class->flags |= Class_::MODIFIER_FINAL;

        return $class;
    }
}
