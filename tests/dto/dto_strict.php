<?php

require_once __DIR__ . '/../utils.php';

$iterations = COUNT_50_MILLIONS;

class TestDTO
{
    public int $attr_int;
    public float $attr_float;
    public string $attr_string;
    public array $attr_array;
}

runPerformanceTestOnlyTime(static function() use ($iterations) {
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
