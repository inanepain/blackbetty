<?php

declare(strict_types=1);

use Inane\Cli\Cli;
use Inane\Cli\Shell;
use Inane\Cli\Streams;
use Inane\Stdlib\Options;

return;
$exitAfterIncludes = true;
$pen->red->line(__FILE__);

// ==================================================================
// Test Cli
// Start code here
// ==================================================================
$optCli = new Options(
    [
        'columns' => true,
        'confirm' => false,
        'prompt'  => false,
    ]
);

if ($optCli->columns) {
    // $divider = str_repeat('=', Shell::columns());
    // Cli::line($divider);
    ($pen->divider)();
    dd('bob');
    dd('hey');
}

if ($optCli->confirm) {
    ($pen->divider)();
    $result = Cli::confirm('Do you want to continue (true)', true);
    dd($result);

    $result = Cli::confirm('Do you want to continue (false)', false);
    dd($result);
}

if ($optCli->prompt) {
    ($pen->divider)();
    $result = Streams::prompt('What\'s your name?', 'Philip Raab', ': ', false);
    Cli::line($result);

    $result = Streams::prompt('What\'s your name (null)?', null, ': ', false);
    Cli::line(($result ?? 'No name given.'));
    if (!$result) {
        dd($result);
    }

    $result = Streams::prompt('What\'s your name (false)?', false, ': ', false);
    Cli::line(($result ?? 'No name given.'));
    if (!$result) {
        dd($result);
    }
}
