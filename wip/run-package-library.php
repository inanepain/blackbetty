<?php

declare(strict_types=1);

use Inane\Cli\Cli;
use Inane\Cli\Shell;
use Inane\Cli\Streams;
use Inane\Stdlib\Options;

return;
$exitAfterIncludes = true;
$pen->red->line(__FILE__);
($pen->divider)();

// ==================================================================
// Test PackageLibrary
// Start code here
// ==================================================================
$optPackageLibrary = new Options([
    'basic' => true,
]);

if ($optPackageLibrary->basic) {
    $pen->red->line('Basic PackageLibrary test');
    ($pen->divider)('-');
    \Dev\Package\PackageLibrary::getInstance()->run();
}

$pen->default->line('');
($pen->divider)();
