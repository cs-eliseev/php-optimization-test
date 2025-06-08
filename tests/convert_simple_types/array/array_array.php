<?php

ini_set('memory_limit', '-1');

$iterations = 500000000;

function showMemory(int $memory): void
{
    print('memory: ' . (memory_get_usage() - $memory) . PHP_EOL);
}

function showTs(float $ts): void
{
    print('ts: ' . str_replace('.', ',', (string)(microtime(true)) - $ts) . PHP_EOL);
}

$collection = [];
$memory = memory_get_usage();
$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $collection[] = [$i];
}
showTs($ts);
showMemory($memory);
