<?php

ini_set('memory_limit', '-1');

$iterations = 10000000;

function showTs(float $ts): void
{
    print(' ts: ' . str_replace('.', ',', (string)(microtime(true) - $ts)) . PHP_EOL);
}

$collection = [];
for ($i = 0; $i < $iterations; $i++) {
    $collection[] = ['test' => $i];
}

$ts = microtime(true);
foreach ($collection as $item) {
}
showTs($ts);