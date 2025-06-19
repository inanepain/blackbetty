<?php

declare(strict_types=1);

use Inane\File\File;
use Inane\File\Path;
use MatthiasMullie\Minify;
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
        'inaneExtend' => true,
        'css' => false,
        'js' => false,
    ]
);

if ($optCli->inaneExtend) {
    $path = new Path('public\js\inane\extend');
    foreach ($path->getFiles('*.min.*js') as $file) {
        $file->remove();
        $pen->default->line('Remove: ' . (string)$file);
    }

    $minifier = new Minify\JS();
    $extend = '';
    // $files = [];
    foreach ($path->getFiles('*.*js') as $file) {
        $pen->default->out('Minifying: ' . (string)$file . '...');

        if (!str_ends_with((string)$file, '.mjs') && !str_ends_with((string)$file, 'extend.js')) {
            $extend .= $file->read() . PHP_EOL;
            $minifier->add((string)$file);
        }
        new Minify\JS((string)$file)->minify(str_replace(['.js', '.mjs'], ['.min.js', '.min.mjs'], (string)$file));

        $pen->default->line(' done');
    }
    $pen->default->line('Creating: extend.js');
    $file = new File('public\js\inane\extend\extend.js');
    $file->remove();
    $file->write($extend);
    $minifier->minify('public\js\inane\extend\extend.min.js');
    $pen->default->out('Minifying: extend.js...');
    $pen->default->line(' done');
}

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
