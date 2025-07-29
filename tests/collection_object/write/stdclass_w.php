<?php

require_once __DIR__.'/../../utils.php';

$iterations = COUNT_50_MILLIONS;

runPerformanceTest(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $item = new stdClass();
        $item->attr_int = $i;
        $item->attr_float = (float) $i;
        $item->attr_string = (string) $i;
        $item->attr_array = [
            $i,
            (float) $i,
            (string) $i
        ];
        $collection[] = $item;
    }
});
