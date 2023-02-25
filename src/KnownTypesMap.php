<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard;

use Illuminate\Support\ServiceProvider;
use TomasVotruba\PunchCard\Contracts\TypeInterface;
use TomasVotruba\PunchCard\ValueObject\Types\ArrayType;
use TomasVotruba\PunchCard\ValueObject\Types\ClassStringType;
use TomasVotruba\PunchCard\ValueObject\Types\IntegerType;
use TomasVotruba\PunchCard\ValueObject\Types\MixedType;
use TomasVotruba\PunchCard\ValueObject\Types\StringType;

final class KnownTypesMap
{
    public static function match(string $shortFileName, string $parameterName): ?TypeInterface
    {
        $typeMapByFileName = [
            'app' => [
                'providers' => new ArrayType(new ClassStringType(ServiceProvider::class)),
                'aliases' => new ArrayType(new StringType()),
            ],
            'sanctum' => [
                'expiration' => new IntegerType(true),
            ],
            'cache' => [
                'stores' => new ArrayType(new MixedType()),
            ],
        ];

        return $typeMapByFileName[$shortFileName][$parameterName] ?? null;
    }
}
