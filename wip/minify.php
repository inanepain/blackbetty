<?php

declare(strict_types=1);

use MatthiasMullie\Minify;
use Inane\Stdlib\Options;

$exitAfterIncludes = true;
$pen->red->line(__FILE__);

// ==================================================================
// Test Cli
// Start code here
// ==================================================================
$optCli = new Options(
    [
        'css' => false,
        'js' => true,
    ]
);

if ($optCli->css) {
    $sourcePath = '/path/to/source/css/file.css';
    $minifier = new Minify\CSS($sourcePath);

    // we can even add another file, they'll then be
    // joined in 1 output file
    $sourcePath2 = '/path/to/second/source/css/file.css';
    $minifier->add($sourcePath2);

    // or we can just add plain CSS
    $css = 'body { color: #000000; }';
    $minifier->add($css);

    // save minified file to disk
    $minifiedPath = '/path/to/minified/css/file.css';
    $minifier->minify($minifiedPath);

    // or just output the content
    echo $minifier->minify();
}

if ($optCli->js) {
    $sourcePath = 'public\js\test.mjs';
    $minifier = new Minify\JS($sourcePath);

    // we can even add another file, they'll then be
    // joined in 1 output file
    // $sourcePath2 = 'public\js\test.mjs';
    // $minifier->add($sourcePath2);

    // or we can just add plain CSS
    // $css = 'body { color: #000000; }';
    // $minifier->add($css);

    // save minified file to disk
    $minifiedPath = 'public\js\test.min.mjs';
    $minifier->minify($minifiedPath);

    // or just output the content
    echo $minifier->minify();
}
