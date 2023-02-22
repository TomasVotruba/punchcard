<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\PhpParser;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\PrettyPrinter\Standard;

final class PhpNodesPrinter extends Standard
{
    /**
     * @see https://regex101.com/r/qZiqGo/13
     * @var string
     */
    private const REPLACE_COLON_WITH_SPACE_REGEX = '#(^.*function .*\(.*\)) : #';

    protected function pExpr_Array(Array_ $node): string
    {
        // short [] by default
        $node->setAttribute('kind', Array_::KIND_SHORT);
        return parent::pExpr_Array($node);
    }

    /**
     * "...$params) : ReturnType"
     * ↓
     * "...$params): ReturnType"
     */
    protected function pStmt_ClassMethod(ClassMethod $classMethod): string
    {
        $content = parent::pStmt_ClassMethod($classMethod);

        if (! $classMethod->returnType instanceof Node) {
            return $content;
        }

        // this approach is chosen, to keep changes in parent pStmt_ClassMethod() updated
        return str($content)->replaceMatches(self::REPLACE_COLON_WITH_SPACE_REGEX, '$1: ')->value();
    }
}
