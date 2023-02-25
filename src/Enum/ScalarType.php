<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Enum;

final class ScalarType
{
    /**
     * @var string
     */
    public const ARRAY = 'array';

    /**
     * @var string
     */
    public const STRING = 'string';

    /**
     * @var string
     */
    public const INTEGER = 'int';

    /**
     * @var string
     */
    public const BOOLEAN = 'bool';

    /**
     * @var string
     */
    public const FLOAT = 'float';

    /**
     * @var string
     */
    public const MIXED = 'mixed';

    /**
     * @var string
     */
    public const NULLABLE_INTEGER = '?int';
}
