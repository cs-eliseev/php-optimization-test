<?php

require_once __DIR__ . '/../utils.php';

$iterations = COUNT_50_MILLIONS;

class TestDTO
{
    public function __construct(
        public int $attr_int,
        public float $attr_float,
        public string $attr_string,
        public array $attr_array
    ) {
    }
}

runPerformanceTestOnlyTime(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $item = new TestDTO($i, (float)$i, (string)$i, [
            $i,
            (float)$i,
            (string)$i
        ]);
        $collection[] = $item;
    }
});
