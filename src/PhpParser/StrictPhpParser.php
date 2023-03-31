<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\PhpParser;

use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use Webmozart\Assert\Assert;

final class StrictPhpParser
{
    private readonly Parser $parser;

    public function __construct()
    {
        $parserFactory = new ParserFactory();
        $this->parser = $parserFactory->create(ParserFactory::PREFER_PHP7);
    }

    /**
     * @return Stmt[]
     */
    public function parse(string $fileContents): array
    {
        $stmts = $this->parser->parse($fileContents);
        Assert::isArray($stmts);

        // decorate name nodes, to keep them FQN even under namespace
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new NameResolver());
        $nodeTraverser->traverse($stmts);

        // keep functions clean, already short names
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new class() extends NodeVisitorAbstract {
            public function enterNode(\PhpParser\Node $node): ?\PhpParser\Node
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
        });
        $nodeTraverser->traverse($stmts);

        return $stmts;
    }
}
