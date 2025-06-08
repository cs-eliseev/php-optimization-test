<?php

ini_set('memory_limit', '-1');

$iterations = 500000000;

function showTs(float $ts): void
{
    print(' ts: ' . str_replace('.', ',', (string)(microtime(true) - $ts)) . PHP_EOL);
}

$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $test = (int) $i;
}
showTs($ts);
