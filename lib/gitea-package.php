<?php

declare(strict_types=1);

use Inane\Cli\Cli;
use Inane\File\File;
use Inane\File\Path;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

Cli::line('Gitea package uploader.' . PHP_EOL);

// Get files from downloads that might be a package
$path = new Path('C:/Users/Philip/Downloads');
$files = $path->getFiles('*-*.*.*.zip');

if (empty($files)) {
    Cli::line('No possible package upload files found.');
    exit;
}

$items = [];
foreach ($files as $file) $items["$file"] = $file->getBasename();

$path = Cli::menu($items, null, 'Please pick a file to upload', 1);
Cli::line();

// Parsing package name & version
$fn = basename(end(explode('/', $path)), '.zip');
[$packageName, $version] = explode('-', $fn);

// Getting vendor
$vendor = Cli::menu(['inanepain'=>'inanepain', 'cathedral'=>'cathedral'], 'inanepain', 'Please pick vendor', 1);
Cli::line();

// Building curl command
$cmd_upload = "curl -k --user philip:Esoter1c!@ --upload-file \"$path\" https://localhost:3000/api/packages/{$vendor}/composer?version={$version}";
Cli::line('Upload command:' . PHP_EOL . $cmd_upload);

// Run command
if (Cli::confirm('Do you want to run this command? (y/n)', 'n')) {
    Cli::line('Running command...');
    shell_exec($cmd_upload);
}

// Delete file
Cli::line();
if (Cli::confirm("Delete file [$path]? (y/n)", 'y')) {
    Cli::line("Deleting file... $path");
    new File($path)->remove();
}
