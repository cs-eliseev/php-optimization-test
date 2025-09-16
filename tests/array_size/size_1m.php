<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_1_MILLION;

runPerformanceTest(static function() use ($iterations) {
    $collection = createCollectionByValue($iterations);
}, $iterations);
