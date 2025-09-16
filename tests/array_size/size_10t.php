<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_10_THOUSAND;

runPerformanceTest(static function() use ($iterations) {
    $collection = createCollectionByValue($iterations);
}, $iterations);
