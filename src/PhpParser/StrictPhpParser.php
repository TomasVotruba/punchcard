<?php

declare(strict_types=1);

namespace TomasVotruba\PunchCard\PhpParser;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use TomasVotruba\PunchCard\NodeVisitor\UnprefixFuncCallNamesNodeVisitor;
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

        $this->makeClassNamesFullyQualified($stmts);

        return $stmts;
    }

    /**
     * @param Stmt[] $stmts
     */
    private function makeClassNamesFullyQualified(array $stmts): void
    {
        // decorate name nodes, to keep them FQN even under namespace
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new NameResolver());
        $nodeTraverser->traverse($stmts);

        // keep functions clean, already short names
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new UnprefixFuncCallNamesNodeVisitor());
        $nodeTraverser->traverse($stmts);
    }
}
