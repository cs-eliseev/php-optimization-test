<?php

require_once __DIR__ . '/../utils.php';

$iterations = COUNT_50_MILLIONS;

class TestDTO
{
    public $attr_int;
    public $attr_float;
    public $attr_string;
    public $attr_array;

    public static function create(int $attr_int, float $attr_float, string $attr_string, array $attr_array): static
    {
        $self = new static();
        $self->attr_int = $attr_int;
        $self->attr_float = $attr_float;
        $self->attr_string = $attr_string;
        $self->attr_array = $attr_array;
        return $self;
    }
}

runPerformanceTestOnlyTime(static function() use ($iterations) {
    $collection = [];
    for ($i = 0; $i < $iterations; $i++) {
        $item = TestDTO::create(
            $i,
            (float) $i,
            (string) $i,
            [
                $i,
                (float) $i,
                (string) $i
            ]
        );
        $collection[] = $item;
    }
});
