<?php

declare(strict_types=1);

use TomasVotruba\PunchCard\Kernel\ApplicationFactory;

$packageComposerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($packageComposerAutoload)) {
    require_once $packageComposerAutoload;
} else {
    // dependency autoloader
    require_once __DIR__ . '/../../../autoload.php';
}


$applicationFactory = new ApplicationFactory();
$application = $applicationFactory->create();

$status = $application->run();

exit($status);
