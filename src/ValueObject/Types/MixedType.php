<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject\Types;

use TomasVotruba\PunchCard\Contracts\TypeInterface;

final class MixedType implements TypeInterface
{
    public function __construct(
        private readonly bool $isNullable = false
    ) {
    }

    public function renderTypeDoc(): string
    {
        return 'mixed';
    }

    public function renderTypeDeclaration(): string
    {
        return '';
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}
