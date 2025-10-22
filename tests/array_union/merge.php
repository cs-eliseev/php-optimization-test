<?php

require_once __DIR__.'/../utils.php';

$iterations = COUNT_250_MILLIONS;

$collection_1 = [];
$collection_2 = [];
for ($i = 0; $i < $iterations; $i++) {
    $collection_1[] = $i;
    $collection_2[] = $i;
}

runPerformanceTest(static function() use ($collection_1, $collection_2) {
    $new = array_merge($collection_1, $collection_2);
});
