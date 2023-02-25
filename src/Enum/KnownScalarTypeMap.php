<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Enum;

final class KnownScalarTypeMap
{
    /**
     * @var array<string, array<string, string>>
     */
    public const TYPE_MAP_BY_FILE_NAME = [
        'app' => [
            'key' => ScalarType::STRING,
            'provides' => 'array<class-string<\Illuminate\Support\ServiceProvider>>',
        ],
        'sanctum' => [
            'expiration' => ScalarType::NULLABLE_INTEGER,
        ],
    ];
}
