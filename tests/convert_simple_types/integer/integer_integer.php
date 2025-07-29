<?php

require_once __DIR__.'/../../utils.php';

$iterations = COUNT_500_MILLIONS;

runPerformanceTestOnlyTime(static function() use ($iterations) {
    for ($i = 0; $i < $iterations; $i++) {
        $test = (int) $i;
    }
});