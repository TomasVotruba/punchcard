<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject;

use TomasVotruba\PunchCard\Enum\ScalarType;

final class ParameterAndType
{
    public function __construct(
        private readonly string $name,
        private readonly string $type,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ScalarType::*
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function getVariableName(): string
    {
        return str($this->name)->camel()->value();
    }

    public function isNullableType(): bool
    {
        return in_array($this->type, [ScalarType::NULLABLE_STRING, ScalarType::NULLABLE_INTEGER], true);
    }
}
