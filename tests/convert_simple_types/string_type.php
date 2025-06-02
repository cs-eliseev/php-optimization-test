<?php

ini_set('memory_limit', '-1');

$iterations = 500000000;

function showTs(float $ts): void
{
    print(' ts: ' . str_replace('.', ',', (string)(microtime(true) - $ts)) . PHP_EOL);
}

$collection = [];
for ($i = 0; $i < $iterations; $i++) {
    $collection[] = (string) $i;
}

$ts = microtime(true);
foreach ($collection as $i) {
    $test = $i;
}
print('Base');
showTs($ts);

$ts = microtime(true);
foreach ($collection as $i) {
    $test = (string) $i;
}
print('String');
showTs($ts);

$ts = microtime(true);
foreach ($collection as $i) {
    $test = (int) $i;
}
print('Integer');
showTs($ts);

$ts = microtime(true);
foreach ($collection as $i) {
    $test = (float) $i;
}
print('Float');
showTs($ts);
