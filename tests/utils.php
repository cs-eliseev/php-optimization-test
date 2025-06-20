<?php

/**
 * Set unlimited memory limit for performance testing
 */
ini_set('memory_limit', '-1');

/**
 * Default number of iterations for performance tests
 */
const MAX_TEST_ITERATIONS = 1000000000;
const DEFAULT_TEST_ITERATIONS = 500000000;
const ARRAY_TEST_ITERATIONS = 150000000;

/**
 * Display data
 *
 * @param string $label
 * @param float $data
 *
 * @return void
 */
function displayFloat(string $label, float $data): void
{
    print("{$label}: " . str_replace('.', ',', (string) $data) . PHP_EOL);
}

/**
 * Display memory usage difference
 * 
 * @param int $memory Initial memory usage
 */
function showMemory(int $memory): void
{
    displayFloat('memory', (memory_get_peak_usage(true) - $memory) / (1024 ** 3));
}

/**
 * Display execution time difference
 * 
 * @param float $ts Initial timestamp
 */
function showTs(float $ts): void
{
    displayFloat('ts', microtime(true) - $ts);
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

