<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject;

use TomasVotruba\PunchCard\Enum\ScalarType;

final class ParameterAndType
{
    public function __construct(
        private readonly string $name,
        private readonly string $propertyType,
        private readonly string $setterParamType,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ScalarType::*|string
     */
    public function getPropertyType(): string
    {
        return $this->propertyType;
    }

    public function getPropertyTypeDeclaration(): string
    {
        if (str_starts_with($this->propertyType, 'array<')) {
            return 'array';
        }

        if (str_ends_with($this->propertyType, '[]')) {
            return 'array';
        }

        return $this->propertyType;
    }

    public function getVariableName(): string
    {
        return str($this->name)->camel()->value();
    }

    /**
     * @return ScalarType::*|string
     */
    public function getSetterParamType(): string
    {
        return $this->setterParamType;
    }

    /**
     * Must be valid PHP
     */
    public function getSetterParamTypeDeclaration(): string
    {
        if (str_starts_with($this->setterParamType, 'array<')) {
            return 'array';
        }

        if (str_ends_with($this->setterParamType, '[]')) {
            return 'array';
        }

        return $this->setterParamType;
    }

    public function isPropertyNullableType(): bool
    {
        return in_array($this->propertyType, [ScalarType::NULLABLE_STRING, ScalarType::NULLABLE_INTEGER], true);
    }

    public function isArrayType(): bool
    {
        return $this->getPropertyTypeDeclaration() === 'array';
    }
}
