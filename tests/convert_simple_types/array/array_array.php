<?php

require_once __DIR__.'/../../utils.php';

$iterations = COUNT_150_MILLIONS;

runPerformanceTest(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $collection[] = [$i];
    }
});