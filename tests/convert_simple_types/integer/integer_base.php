<?php

require_once __DIR__.'/../../../tests/utils.php';

$iterations = DEFAULT_TEST_ITERATIONS;

runPerformanceTestOnlyTime(static function() use ($iterations) {
    for ($i = 0; $i < $iterations; $i++) {
        $test = (int) $i;
    }
});
