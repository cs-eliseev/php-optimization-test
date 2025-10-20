<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_100_MILLIONS;

runPerformanceTest(static function() use ($iterations) {
    $collection = array_fill(0, $iterations, COUNT_1_BILLION);
}, $iterations);
