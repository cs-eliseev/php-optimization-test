<?php

/**
 * Set unlimited memory limit for performance testing
 */
ini_set('memory_limit', '-1');

/**
 * Default number of iterations for performance tests
 */
const COUNT_1_BILLION = 1000000000;
const COUNT_500_MILLIONS = 500000000;
const COUNT_250_MILLIONS = 250000000;
const COUNT_150_MILLIONS = 150000000;
const COUNT_100_MILLIONS = 100000000;
const COUNT_50_MILLIONS = 50000000;
const COUNT_10_MILLION = 10000000;
const COUNT_5_MILLION = 5000000;
const COUNT_1_MILLION = 1000000;
const COUNT_500_THOUSAND = 500000;
const COUNT_100_THOUSAND = 100000;
const COUNT_50_THOUSAND = 50000;
const COUNT_10_THOUSAND = 10000;
const COUNT_5_THOUSAND = 5000;
const COUNT_1_THOUSAND = 1000;

const LABEL_MEMORY = 'memory';
const LABEL_TIME = 'ts';

/**
 * Calculate elapsed time
 *
 * @param float $ts
 *
 * @return float
 */
function timeSince(float $ts): float
{
    return microtime(true) - $ts;
}

/**
 * Calculate used memory
 *
 * @param int $memory
 *
 * @return int
 */
function memoryUsedSince(int $memory): int
{
    return memory_get_peak_usage(true) - $memory;
}

/**
 * Convert bytes to gigabytes
 *
 * @param int $bytes
 *
 * @return float
 */
function byteToGb(int $bytes): float
{
    return $bytes / (1024 ** 3);
}

/**
 * Display data
 *
 * @param string $label
 * @param string|int|float $data
 *
 * @return void
 */
function display(string $label, $data): void
{
    print("{$label}: {$data}" . PHP_EOL);
}

/**
 * Display float data
 *
 * @param string $label
 * @param float $data
 *
 * @return void
 */
function displayFloat(string $label, float $data): void
{
    display($label, str_replace('.', ',', (string) $data));
}

/**
 * Display memory usage difference
 * 
 * @param int $memory Initial memory usage
 * @param string $label Label
 */
function showMemory(int $memory, string $label = LABEL_MEMORY): void
{
    displayFloat($label, byteToGb(memoryUsedSince($memory)));
}

/**
 * Display execution time difference
 * 
 * @param float $ts Initial timestamp
 * @param string $label Label
 */
function showTs(float $ts, string $label = LABEL_TIME): void
{
    displayFloat($label, timeSince($ts));
}

/**
 * Run performance test with memory and time measurements
 * 
 * @param callable $testFunction Function to test
 */
function runPerformanceTest(callable $testFunction): void
{
    $memory = memory_get_peak_usage(true);
    $ts = microtime(true);

    $testFunction();

    showTs($ts);
    showMemory($memory);
}

/**
 * Run performance test with time measurements
 * 
 * @param callable $testFunction Function to test
 */
function runPerformanceTestOnlyTime(callable $testFunction): void
{
    $ts = microtime(true);
    
    $testFunction();
    
    showTs($ts);
} 

