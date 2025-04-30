<?php

declare(strict_types=1);

use Inane\Cli\Cli;
use Inane\Cli\Streams;

$exitAfterIncludes = true;
$pen->red->line(__FILE__);

$result = Cli::confirm('Do you want to continue (true)', true);
dd($result);

$result = Cli::confirm('Do you want to continue (false)', false);
dd($result);

if (!true) {
    $result = Streams::prompt('What\'s your name?', 'Philip Raab', ': ', false);
    Cli::line($result);

    $result = Streams::prompt('What\'s your name (null)?', null, ': ', false);
    Cli::line($result ?? 'No name given.');
    if (!$result) dd($result);

    $result = Streams::prompt('What\'s your name (false)?', false, ': ', false);
    Cli::line($result ?? 'No name given.');
    if (!$result) dd($result);
}
