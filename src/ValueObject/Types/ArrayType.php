<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\ValueObject\Types;

use TomasVotruba\PunchCard\Contracts\TypeInterface;

final class ArrayType implements TypeInterface
{
    public function __construct(
        private readonly TypeInterface $valueType,
        private readonly bool $isNullable = false
    ) {
    }

    public function renderTypeDoc(): string
    {
        if ($this->valueType instanceof ClassStringType) {
            return 'array<' . $this->valueType->renderTypeDoc() . '>';
        }

        return $this->valueType->renderTypeDoc() . '[]';
    }

    public function renderTypeDeclaration(): string
    {
        return 'array';
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}
