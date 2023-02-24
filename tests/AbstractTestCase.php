<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Tests;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @template TType as object
     * @param class-string<TType> $class
     * @return TType
     */
    protected function make(string $class): object
    {
        $container = new Container();
        return $container->make($class);
    }
}
