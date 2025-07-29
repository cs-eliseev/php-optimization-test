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
    $write_at = microtime(true);
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
    showTs($write_at, 'write_at');
    $read_at = microtime(true);
    foreach ($collection as $item) {
        $r_int = $item->attr_int;
        $r_float = $item->attr_float;
        $r_string = $item->attr_string;
        $r_array = $item->attr_array;
    }
    showTs($read_at, 'read_at');
});
