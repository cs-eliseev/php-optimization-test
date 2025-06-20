<?php

require_once __DIR__.'/../../utils.php';

$iterations = ARRAY_TEST_ITERATIONS;

runPerformanceTest(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $collection[] = (float) $i;
    }
});