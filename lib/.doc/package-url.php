<?php

declare(strict_types=1);

$vendor = true ? 'cathedral' : 'inanepain';
$packageName = 'builder';
$version = '0.32.2';

$url = "curl -k --user philip:Esoter1c!@ --upload-file \"C:\Users\Philip\Downloads\\{$packageName}-{$version}.zip\" https://localhost:3000/api/packages/{$vendor}/composer?version={$version}";

echo $url, PHP_EOL;
