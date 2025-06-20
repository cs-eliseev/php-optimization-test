<?php

require_once __DIR__ . '/../utils.php';

$collection = [];
for ($i = 0; $i < DEFAULT_TEST_ITERATIONS; $i++) {
    $collection[] = ['test' => $i];
}

runPerformanceTestOnlyTime(static function() use ($collection) {
    $cnt = count($collection);
    for ($i = 0; $i <= $cnt; $i++) {
        $item = $collection[$i];
    }
});
