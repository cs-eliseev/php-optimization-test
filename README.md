English | [Русский](README.ru_RU.md)

# PHP Performance Testing Project

This project contains a collection of PHP scripts designed to test and analyze performance across different PHP versions. It allows you to compare execution time and memory usage of various PHP operations.

## Features
- Collection of performance test PHP scripts
- Docker-based testing environment
- Support for PHP versions from 7.4 to 8.5
- Various test scenarios
- Exporting results to various formats (CSV, Excel, JSON)

## Requirements
- Docker and Docker Compose
- Python 3.8 or higher
- Bash

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd <repository-directory>
```

2. Run the initialization script:
```bash
./init_venv.sh
```

## Usage

### Run all tests

```bash
./run_report.sh
```

This will start containers for PHP versions:
- PHP 7.4 (port 9022)
- PHP 8.0 (port 9023)
- PHP 8.1.25 (port 9024)
- PHP 8.2.12 (port 9025)
- PHP 8.3 (port 9026)
- PHP 8.4 (port 9027)
- PHP 8.5 (port 9028)

### Run tests in a specific directory

```bash
./run_report.sh path/to/test/directory
```

### Export results

```bash
# Export to CSV
./run_report.sh path/to/test/directory --csv results.csv

# Export to Excel
./run_report.sh path/to/test/directory --excel results.xlsx

# Export to JSON
./run_report.sh path/to/test/directory --json results.json

# Combined export
./run_report.sh path/to/test/directory --csv results.csv --excel results.xlsx --json results.json
```

## Results Structure

Results are grouped by directories and include:
- Execution time (ts, sec)
- Memory usage (memory, GB)

### JSON Format

```json
{
    "directory_name": {
        "test_file.php": {
            "ts": {
                "7.4": "0.123",
                "8.0": "0.120",
                "8.1": "0.118",
                "8.2": "0.115",
                "8.3": "0.112"
            },
            "memory": {
                "7.4": "0.5",
                "8.0": "0.48",
                "8.1": "0.45",
                "8.2": "0.42",
                "8.3": "0.40"
            }
        }
    }
}
```

### Test Structure
The `tests` directory contains various test scenarios:
- `convert_simple_types/` - Tests for type conversion performance
- `curly_braces/` - Tests for curly braces performance
- `foreach_bug/` - Tests for foreach loop optimization