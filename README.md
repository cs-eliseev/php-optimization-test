English | [Русский](README.ru_RU.md)

# PHP Performance Testing Project

This project contains a collection of PHP scripts designed to test and analyze performance across different PHP versions. It allows you to compare execution time and memory usage of various PHP operations.

### Features
- Collection of performance test scripts
- Docker-based testing environment
- Support for PHP versions from 7.4 to 8.4
- Various test scenarios including:
  - Type conversion tests
  - Array operations
  - DTO (Data Transfer Object) performance
  - Foreach loop optimization
  - Array vs DTO comparisons

### Requirements
- Docker and Docker Compose
- PHP 7.4 or higher (for local development)
- Git

### Installation
```bash
git clone [repository-url]
cd [repository-name]
```

### Running Tests
The project uses Docker containers for testing different PHP versions. To start the test environment:

```bash
docker-compose up -d
```

This will start containers for PHP versions:
- PHP 7.4 (port 9022)
- PHP 8.0 (port 9023)
- PHP 8.1.25 (port 9024)
- PHP 8.2.12 (port 9025)
- PHP 8.3 (port 9026)
- PHP 8.4 (port 9027)

Each container mounts the `tests` directory, allowing you to run the same tests across different PHP versions.

### Container Usage Examples

#### Copying Scripts to Container
```bash
# Copy script to PHP 7.4 container
docker cp tests/foreach_bug/dto_collection.php my-php7_4-container:test.php

# Copy script to PHP 8.0 container
docker cp tests/foreach_bug/dto_collection.php my-php8_0-container:test.php
```

#### Running Scripts in Container
```bash
# Run script in PHP 7.4 container
docker exec my-php7_4-container php test.php

# Run script in PHP 8.0 container
docker exec my-php8_0-container php test.php
```

### Test Structure
The `tests` directory contains various test scenarios:
- `convert_simple_types/` - Tests for type conversion performance
- `curly_braces/` - Tests for curly braces performance
- `foreach_bug/` - Tests for foreach loop optimization