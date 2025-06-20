<?php

require_once __DIR__ . '/../utils.php';

class TestDTO
{
    public $attr_int;
    public $attr_float;
    public $attr_string;
    public $attr_array;
}

$collection = [];
for ($i = 0; $i < DEFAULT_TEST_ITERATIONS; $i++) {
    $item = new TestDTO();
    $item->attr_int = $i;
    $collection[] = $item;
}

runPerformanceTestOnlyTime(static function() use ($collection) {
    foreach ($collection as $item) {
    }
});