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
     * @return ScalarType::*
     */
    public function getPropertyType(): string
    {
        return $this->propertyType;
    }

    public function getVariableName(): string
    {
        return str($this->name)->camel()->value();
    }

    /**
     * @return ScalarType::*
     */
    public function getSetterParamType(): string
    {
        return $this->setterParamType;
    }

    public function isPropertyNullableType(): bool
    {
        return in_array($this->propertyType, [ScalarType::NULLABLE_STRING, ScalarType::NULLABLE_INTEGER], true);
    }
}
