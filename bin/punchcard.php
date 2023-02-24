<?php

// generated config from provided path or directory

// bind Console kernel to custom? :)

use TomasVotruba\PunchCard\Kernel\ApplicationFactory;

$vendorAutoload = file_exists(__DIR__ . '/../vendor/autoload.php') ? __DIR__ . '/../vendor/autoload.php' : __DIR__ . '/../../../autoload.php';

$autoloader = require_once $vendorAutoload;

$applicationFactory = new ApplicationFactory();
$app = $applicationFactory->create();

/** @var \TomasVotruba\PunchCard\Kernel\PunchcardKernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

$kernel->terminate($input, $status);

exit($status);
