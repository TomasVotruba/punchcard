<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Contracts;

interface TypeInterface
{
    public function renderTypeDoc(): string;

    public function renderTypeDeclaration(): string;

    public function isNullable(): bool;
}
