<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\PhpParser;

use Nette\Utils\Strings;
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

    /**
     * Remove extra spaces before new Nop_ nodes
     * @see https://regex101.com/r/iSvroO/1
     * @var string
     */
    private const EXTRA_SPACE_BEFORE_NOP_REGEX = '#^[ \t]+$#m';

    protected function pExpr_Array(Array_ $array): string
    {
        // short [] by default
        $array->setAttribute('kind', Array_::KIND_SHORT);
        return parent::pExpr_Array($array);
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
        return str($content)
            ->replaceMatches(self::REPLACE_COLON_WITH_SPACE_REGEX, '$1: ')
            ->value();
    }

    /**
     * @param mixed[] $nodes
     * @param mixed[] $origNodes
     * @param int|null $fixup
     */
    protected function pArray(
        array $nodes,
        array $origNodes,
        int &$pos,
        int $indentAdjustment,
        string $parentNodeType,
        string $subNodeName,
        $fixup
    ): ?string {
        $content = parent::pArray($nodes, $origNodes, $pos, $indentAdjustment, $parentNodeType, $subNodeName, $fixup);

        if ($content === null) {
            return $content;
        }

        dump(str($content)->replaceMatches($content, self::EXTRA_SPACE_BEFORE_NOP_REGEX)->value());
        die;

        return str($content)->replaceMatches($content, self::EXTRA_SPACE_BEFORE_NOP_REGEX)->value();
    }
}
