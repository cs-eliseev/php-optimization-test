<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_5_THOUSAND;

runPerformanceTest(static function() use ($iterations) {
    $collection = createCollectionByValue($iterations);
}, $iterations);
