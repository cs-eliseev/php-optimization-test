<?php

require_once __DIR__.'/../../utils.php';

$iterations = COUNT_50_MILLIONS;

runPerformanceTest(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $item = [];
        $item[] = $i;
        $item[] = (float) $i;
        $item[] = (string) $i;
        $item[] = [
            $i,
            (float) $i,
            (string) $i
        ];
        $collection[] = $item;
    }
});
