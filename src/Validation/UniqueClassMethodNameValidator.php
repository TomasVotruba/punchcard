<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\Validation;

use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use TomasVotruba\PunchCard\Exception\ShouldNotHappenException;

final class UniqueClassMethodNameValidator
{
    public function __construct(
        private readonly NodeFinder $nodeFinder
    ) {
    }

    /**
     * @param Stmt[] $classStmts
     */
    public function ensureMethodNamesAreUnique(array $classStmts): void
    {
        $classMethodNames = $this->resolveClassMethodNames($classStmts);

        foreach (array_count_values($classMethodNames) as $methodName => $count) {
            if ($count < 2) {
                continue;
            }

            throw new ShouldNotHappenException(sprintf('Method name "%s()" is duplicated', $methodName));
        }
    }

    /**
     * @param Stmt[] $stmts
     * @return string[]
     */
    private function resolveClassMethodNames(array $stmts): array
    {
        /** @var ClassMethod[] $classMethods */
        $classMethods = $this->nodeFinder->findInstanceOf($stmts, ClassMethod::class);

        $classMethodNames = array_map(
            static fn (ClassMethod $classMethod): string => $classMethod->name->toString(),
            $classMethods
        );
        sort($classMethodNames);

        return $classMethodNames;
    }
}
