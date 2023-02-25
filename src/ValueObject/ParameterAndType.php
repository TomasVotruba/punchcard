<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject;

use TomasVotruba\PunchCard\Contracts\TypeInterface;
use TomasVotruba\PunchCard\ValueObject\Types\ArrayType;

final class ParameterAndType
{
    public function __construct(
        private readonly string $name,
        private readonly TypeInterface $propertyType,
        private readonly TypeInterface $setterParamType,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function renderPropertyTypeDoc(): string
    {
        return $this->propertyType->renderTypeDoc();
    }

    public function getPropertyType(): TypeInterface
    {
        return $this->propertyType;
    }

    public function getPropertyTypeDeclaration(): string
    {
        return $this->propertyType->renderTypeDeclaration();
    }

    public function getVariableName(): string
    {
        return str($this->name)->camel()->value();
    }

    public function getSetterParamType(): TypeInterface
    {
        return $this->setterParamType;
    }

    /**
     * Must be valid PHP
     */
    public function getSetterParamTypeDeclaration(): string
    {
        return $this->setterParamType->renderTypeDeclaration();
    }

    public function isPropertyNullableType(): bool
    {
        return $this->propertyType->isNullable();
    }

    public function isArrayType(): bool
    {
        return $this->propertyType instanceof ArrayType;
        //return $this->getPropertyTypeDeclaration() === 'array';
    }
}
