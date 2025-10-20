<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_20_MILLIONS;

runPerformanceTest(static function() use ($iterations) {
    $collection = createCollectionByValue($iterations);
    $collection1 = createCollectionByValue($iterations);
    $collection2 = createCollectionByValue($iterations);
}, $iterations);
