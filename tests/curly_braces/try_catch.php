<?php

ini_set('memory_limit', '-1');

function showTs(float $ts): void
{
    print('ts: ' . str_replace('.', ',', (string)(microtime(true) - $ts)) . PHP_EOL);
}

$iterations = 50000000;

$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    try {
        $a = 10;
    } catch (Throwable $exception) {
        // do nothing
    }
}
showTs($ts);
