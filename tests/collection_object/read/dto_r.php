<?php

require_once __DIR__.'/../../utils.php';

$iterations = COUNT_50_MILLIONS;

class TestDTO
{
    public $attr_int;
    public $attr_float;
    public $attr_string;
    public $attr_array;
}

$collection = [];
for ($i = 0; $i < $iterations; $i++) {
    $item = new TestDTO();
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

runPerformanceTestOnlyTime(static function() use ($collection) {
    foreach ($collection as $item) {
        $r_int = $item->attr_int;
        $r_float = $item->attr_float;
        $r_string = $item->attr_string;
        $r_array = $item->attr_array;
    }
});
