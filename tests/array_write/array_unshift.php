<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_100_THOUSAND;

runPerformanceTest(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        array_unshift($collection, $i);
    }
});