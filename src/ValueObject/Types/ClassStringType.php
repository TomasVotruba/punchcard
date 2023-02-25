<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject\Types;

use TomasVotruba\PunchCard\Contracts\TypeInterface;

final class ClassStringType implements TypeInterface
{
    public function __construct(
        private readonly string $className,
    ) {
    }

    public function renderTypeDoc(): string
    {
        return 'class-string<\\' . $this->className . '>';
    }

    public function renderTypeDeclaration(): string
    {
        return 'string';
    }

    public function isNullable(): bool
    {
        return false;
    }
}
