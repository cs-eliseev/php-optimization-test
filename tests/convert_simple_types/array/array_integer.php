<?php

require_once __DIR__.'/../../utils.php';

$iterations = ARRAY_TEST_ITERATIONS;

runPerformanceTest(static function() use ($iterations) {
    echo memory_get_usage(true) . PHP_EOL;
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $collection[] = $i;
    }
    echo memory_get_usage(true) . PHP_EOL;
});