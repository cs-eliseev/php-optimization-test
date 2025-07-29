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

runPerformanceTest(static function() use ($iterations) {
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
});
