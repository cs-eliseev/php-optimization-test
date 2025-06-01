<?php

ini_set('memory_limit', '-1');

$iterations = 10000000;

function showTs(float $ts): void
{
    print(' ts: ' . str_replace('.', ',', (string)(microtime(true) - $ts)) . PHP_EOL);
}

function forCollection(array $collection): void
{
    $cnt = count($collection);
    for ($i = 0; $i <= $cnt; $i++) {
        $item = $collection[$i];
    }
}

class TestDTO
{
    public $attr_int;
    public $attr_float;
    public $attr_string;
    public $attr_array;
}

$collection = [];
for ($i = 0; $i < $iterations; $i++) {
    $item = new TestDTO();
    $item->attr_int = $i;
    $collection[] = $item;
}

$ts = microtime(true);
forCollection($collection);
showTs($ts);