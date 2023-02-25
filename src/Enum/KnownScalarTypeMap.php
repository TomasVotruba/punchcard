<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Enum;

final class KnownScalarTypeMap
{
    /**
     * @var array<string, ScalarType::*>
     */
    public const TYPE_MAP = [
        'expiration' => ScalarType::NULLABLE_INTEGER,
    ];
}
