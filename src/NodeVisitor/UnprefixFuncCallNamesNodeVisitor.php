<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\NodeVisitorAbstract;

final class UnprefixFuncCallNamesNodeVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node): ?Node
    {
        if (! $node instanceof FuncCall) {
            return null;
        }

        if (! $node->name instanceof Name) {
            return null;
        }

        $node->name = new Name($node->name->toString());

        return $node;
    }
}
