<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject\Types;

use TomasVotruba\PunchCard\Contracts\TypeInterface;

final class BooleanType implements TypeInterface
{
    public function __construct(
        private readonly bool $isNullable = false
    ) {
    }

    public function renderTypeDoc(): string
    {
        return 'bool';
    }

    public function renderTypeDeclaration(): string
    {
        return 'bool';
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}
