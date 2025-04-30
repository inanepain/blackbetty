<?php

declare(strict_types=1);

$exitAfterIncludes = true;
$pen->red->line(__FILE__);

// $wf = file_get_contents('/usr/share/dict/british-english-insane');
$wf = file_get_contents(__DIR__ .  '/../data/british-english-insane');
$wa = explode("\n", $wf);
$wa = array_filter($wa);

$r = [];

foreach ($wa as $w) foreach (str_split(strtolower($w)) as $l) if (ctype_alpha($l)) (isset($r[$l])) ? $r[$l]++ : $r[$l] = 1;

ksort($r); // Sort by keys (letters)
asort($r); // Sort by values (frequency)
// print_r($r); // to see

$t = array_sum($r); // Total usage of letters
$d = array_map(fn($k, $v) => [$k => [$v => round($v / $t * 100) . '%']], array_keys($r), array_values($r)); // Create a new array with keys and values swapped
// print_r($r); // to see

array_walk($r, fn($v, $k) => print_r("$k: " . str_pad("$v", strlen("$t"), ' ', STR_PAD_LEFT) . ": " . str_pad('' . round($v / $t * 100), 2, ' ', STR_PAD_LEFT) . '%' . PHP_EOL));

echo "Total letters: " . count($r) . ", usage: $t" . "\n"; // to see
