<?php

ini_set('memory_limit', '-1');

$iterations = 1000000000;

function showTs(float $ts): void
{
    print(' ts: ' . str_replace('.', ',', (string)(microtime(true) - $ts)) . PHP_EOL);
}

$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $test = $i;
}
print('Base');
showTs($ts);

$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $test = (int) $i;
}
print('Integer');
showTs($ts);

$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $test = (float) $i;
}
print('Float');
showTs($ts);

$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $test = (string) $i;
}
print('String');
showTs($ts);
