<?php

require_once __DIR__.'/../../utils.php';

$iterations = DEFAULT_TEST_ITERATIONS;
$collection = [];
for ($i = 0; $i < $iterations; $i++) {
    $collection[] = (string) $i;
}

runPerformanceTestOnlyTime(static function() use ($collection) {
    foreach ($collection as $i) {
        $test = (float) $i;
    }
});
