<?php

require_once __DIR__.'/../../utils.php';

$iterations = COUNT_50_MILLIONS;

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

runPerformanceTestOnlyTime(static function() use ($collection) {
    foreach ($collection as $item) {
        $r_int = $item[0];
        $r_float = $item[1];
        $r_string = $item[2];
        $r_array = $item[3];
    }
});
