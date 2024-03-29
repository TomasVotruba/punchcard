<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeFactory;

use Illuminate\Contracts\Support\Arrayable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Property;
use TomasVotruba\PunchCard\Validation\UniqueClassMethodNameValidator;
use TomasVotruba\PunchCard\ValueObject\ConfigFile;
use TomasVotruba\PunchCard\ValueObject\ParameterTypeAndDefaultValue;
use Webmozart\Assert\Assert;

final class ConfigClassFactory
{
    public function __construct(
        private readonly ToArrayClassMethodFactory $toArrayClassMethodFactory,
        private readonly SetterClassMethodFactory $setterClassMethodFactory,
        private readonly DefaultsClassMethodFactory $defaultsClassMethodFactory,
        private readonly PropertyFactory $propertyFactory,
        private readonly UniqueClassMethodNameValidator $uniqueClassMethodNameValidator,
        private readonly ServiceConfigStmtsFactory $serviceConfigStmtsFactory,
    ) {
    }

    /**
     * @param ParameterTypeAndDefaultValue[] $parameterTypeAndDefaultValues
     */
    public function createClassFromParameterNames(array $parameterTypeAndDefaultValues, ConfigFile $configFile): Class_
    {
        Assert::allIsInstanceOf($parameterTypeAndDefaultValues, ParameterTypeAndDefaultValue::class);

        $class = $this->createClass($configFile);

        // special generic config class
        if ((string) $class->name === 'ServicesConfig') {
            $makeClassMethod = $this->serviceConfigStmtsFactory->createGenericMakeClassMethod();

            $parametersProperty = $this->serviceConfigStmtsFactory->createParametersProperty();
            $servicesClassMethod = $this->serviceConfigStmtsFactory->createServiceClassMethod();
            $toArrayClassMethod = $this->serviceConfigStmtsFactory->createGenericToArrayClassMethod();

            $classStmts = [$parametersProperty, $makeClassMethod, $servicesClassMethod, $toArrayClassMethod];
        } else {
            $makeClassMethod = $this->defaultsClassMethodFactory->createDefaultsClassMethod($parameterTypeAndDefaultValues);

            $toArrayClassMethod = $this->toArrayClassMethodFactory->create($parameterTypeAndDefaultValues);

            $properties = $this->createProperties($parameterTypeAndDefaultValues);
            $classMethods = $this->createClassMethods($parameterTypeAndDefaultValues);

            $classStmts = array_merge($properties, [$makeClassMethod], $classMethods, [$toArrayClassMethod]);
        }

        $this->uniqueClassMethodNameValidator->ensureMethodNamesAreUnique($classStmts);

        // separate by newline to make it standard out of the box
        $class->stmts = $this->separateStmtsByNewline($classStmts);

        return $class;
    }

    /**
     * @param ParameterTypeAndDefaultValue[] $parameterTypeAndDefaultValues
     * @return Property[]
     */
    private function createProperties(array $parameterTypeAndDefaultValues): array
    {
        $properties = [];

        foreach ($parameterTypeAndDefaultValues as $parameterTypeAndDefaultValue) {
            $properties[] = $this->propertyFactory->create($parameterTypeAndDefaultValue);
        }

        return $properties;
    }

    /**
     * @param ParameterTypeAndDefaultValue[] $parameterTypeAndDefaultValues
     * @return ClassMethod[]
     */
    private function createClassMethods(array $parameterTypeAndDefaultValues): array
    {
        $classMethods = [];

        foreach ($parameterTypeAndDefaultValues as $parameterTypeAndDefaultValue) {
            $classMethods[] = $this->setterClassMethodFactory->create($parameterTypeAndDefaultValue);
        }

        return $classMethods;
    }

    private function createClass(ConfigFile $configFile): Class_
    {
        $class = new Class_($configFile->getClassName());
        $class->implements[] = new FullyQualified(Arrayable::class);

        return $class;
    }

    /**
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function separateStmtsByNewline(array $stmts): array
    {
        $separatedStmts = [];

        foreach ($stmts as $stmt) {
            $separatedStmts[] = $stmt;
            $separatedStmts[] = new Nop();
        }

        unset($separatedStmts[array_key_last($separatedStmts)]);

        return $separatedStmts;
    }
}
