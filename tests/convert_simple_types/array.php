<?php

ini_set('memory_limit', '-1');

$iterations = 100000000;

function showMemory(int $memory): void
{
    print('memory: ' . (memory_get_usage() - $memory) . PHP_EOL);
}

function showTs(float $ts): void
{
    print('ts: ' . str_replace('.', ',', (string)(microtime(true)) - $ts) . PHP_EOL);
}

$array = [];
$memory = memory_get_usage();
$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $array[] = $i;
}
print('Array[Integer]');
showTs($ts);
showMemory($memory);

$array = [];
$memory = memory_get_usage();
$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $array[] = (string) $i;
}
print('Array[String]');
showTs($ts);
showMemory($memory);

$array = [];
$memory = memory_get_usage();
$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $array[] = (float) $i;
}
print('Array[Float]');
showTs($ts);
showMemory($memory);

$array = [];
$memory = memory_get_usage();
$ts = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $array[] = [$i];
}
print('Array[Array[Integer]]');
showTs($ts);
showMemory($memory);
