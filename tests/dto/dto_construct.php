<?php

require_once __DIR__ . '/../utils.php';

$iterations = COUNT_50_MILLIONS;

class TestDTO
{
    public $attr_int;
    public $attr_float;
    public $attr_string;
    public $attr_array;
    public function __construct(int $attr_int, float $attr_float, string $attr_string, array $attr_array)
    {
        $this->attr_int = $attr_int;
        $this->attr_float = $attr_float;
        $this->attr_string = $attr_string;
        $this->attr_array = $attr_array;
    }
}

runPerformanceTestOnlyTime(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $item = new TestDTO($i, (float) $i, (string) $i, [
            $i,
            (float) $i,
            (string) $i
        ]);
        $collection[] = $item;
    }
});
