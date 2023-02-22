<?php

namespace TomasVotruba\PunchCard;

use PhpParser\Node\Stmt\Class_;
use PhpParser\ParserFactory;

final class FluentConfigGenerator
{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function generate(array $configuration): Class_
=======
=======
    private \PhpParser\Parser $parser;

    public function __construct()
    {
        $parserFactory = new ParserFactory();
        $this->parser = $parserFactory->create(ParserFactory::PREFER_PHP7);
    }

>>>>>>> 9c24d58 (misc)
    public function generate(string $configFileContents): string
>>>>>>> 02b7b98 (misc)
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        // @todo
=======
        $parserFactory = new ParserFactory();
        $this->parser = $parserFactory->create(ParserFactory::PREFER_PHP7);
    }

    public function generate(string $configFileContents): string
    {

        // @todo parse to build schema :)
        // generate class form schema
=======
    private readonly \PhpParser\Parser $parser;

    public function __construct(
        private readonly ConfigClassFactory $configClassFactory,
        private readonly PhpNodesPrinter $phpNodesPrinter,
    ) {
        $parserFactory = new ParserFactory();
        $this->parser = $parserFactory->create(ParserFactory::PREFER_PHP7);
    }

    public function generate(string $configFileContents): ?string
    {
        $configStmts = $this->parser->parse($configFileContents);
        Assert::allIsInstanceOf($configStmts, Stmt::class);

        $parametersAndTypes = $this->resolveMainParameterNames($configStmts);
        if ($parametersAndTypes === []) {
            return null;
        }

        // create basic class from this one :)
        $class = $this->configClassFactory->createClassFromParameterNames($parametersAndTypes, $fileName);
>>>>>>> 4628eda (fixup! misc)

        $configStmts = $this->parser->parse($configFileContents);
        Assert::allIsInstanceOf($configStmts, Stmt::class);

        ///** @var Stmt $configStmts */
        //foreach ($configStmts as $configStmt) {
        //    if (! $configStmt instanceof Stmt\Return_) {
        //        continue;
        //    }
        //
        //    if (! $configStmt->expr instanceof Array_) {
        //        continue;
        //    }
        //
        //    /** @var Array_ $configArray */
        //    $configArray = $configStmt->expr;
        //
        //    $mainParameterNames = [];
        //
        //
        //    foreach ($configArray->items as $arrayItem) {
        //        Assert::isInstanceOf($arrayItem, ArrayItem::class);
        //
        //        // collect keys and value types :)
        //        if (! $arrayItem->key instanceof String_) {
        //            continue;
        //        }
        //
        //        $mainParameterNames[] = $arrayItem->key->value;
        //    }
        //}

        // create basic class from this one :)
<<<<<<< HEAD


        dump($mainParameterNames);
        die;
>>>>>>> 18c8cbf (fixup! misc)
=======
        $class = $this->configClassFactory->createClassFromParameterNames($mainParameterNames, $fileName);

        return $this->phpNodesPrinter->prettyPrintFile([$class]) . PHP_EOL;
    }

    /**
     * @param Stmt[] $configStmts
     * @return ParameterAndType[]
     */
    private function resolveMainParameterNames(array $configStmts): array
    {
        $parametersAndTypes = [];

        /** @var Stmt[] $configStmts */
        foreach ($configStmts as $configStmt) {
            if (! $configStmt instanceof Return_) {
                continue;
            }

            if (! $configStmt->expr instanceof Array_) {
                continue;
            }

            /** @var Array_ $configArray */
            $configArray = $configStmt->expr;

            foreach ($configArray->items as $arrayItem) {
                Assert::isInstanceOf($arrayItem, ArrayItem::class);

                // collect keys and value types :)
                if (! $arrayItem->key instanceof String_) {
                    continue;
                }

                $parameterName = $arrayItem->key->value;

                // how to resolve type here?
                $scalarType = $this->resolveScalarType($arrayItem);

                $parametersAndTypes[] = new ParameterAndType($parameterName, $scalarType);
            }
        }

        return $parametersAndTypes;
    }

    /**
     * @return ScalarType::*
     */
    private function resolveScalarType(ArrayItem $arrayItem): string
    {
        if ($arrayItem->value instanceof Array_) {
            return ScalarType::ARRAY;
        }

<<<<<<< HEAD
        throw new NotImplementedYetException(
            sprintf('The "%s" type is not implemented yet', get_class($arrayItem->value))
        );
>>>>>>> 4628eda (fixup! misc)
=======
        dump($mainParameterNames);
        die;
>>>>>>> 18c8cbf (fixup! misc)
=======
=======

>>>>>>> 050beac (misc)
        // @todo parse to build schema :)
        // generate class form schema
        dump($configFileContents);

        $configStmts = $this->parser->parse($configFileContents);
        dump($configStmts);
        die;
>>>>>>> 4379e2d (misc)
>>>>>>> 02b7b98 (misc)
    }
}
