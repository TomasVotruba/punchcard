<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Enum;

use Illuminate\Support\ServiceProvider;
use TomasVotruba\PunchCard\Contracts\TypeInterface;
use TomasVotruba\PunchCard\ValueObject\Types\ArrayType;
use TomasVotruba\PunchCard\ValueObject\Types\ClassStringType;
use TomasVotruba\PunchCard\ValueObject\Types\IntegerType;
use TomasVotruba\PunchCard\ValueObject\Types\StringType;

final class KnownTypesMap
{
    public static function match(string $shortFileName, string $parameterName): ?TypeInterface
    {
        $typeMapByFileName = [
            'app' => [
                'key' => new StringType(),
                'providers' => new ArrayType(new ClassStringType(ServiceProvider::class)),
                'aliases' => new ArrayType(new StringType()),
            ],
            'sanctum' => [
                'expiration' => new IntegerType(true),
            ],
        ];

        return $typeMapByFileName[$shortFileName][$parameterName] ?? null;
    }
}
