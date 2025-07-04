[English](README.md) | Русский

# Проект тестирования производительности PHP

Этот проект содержит набор PHP-скриптов, предназначенных для тестирования и анализа производительности в различных версиях PHP. Он позволяет сравнивать время выполнения и использование памяти различных PHP-операций.

## Возможности
- Набор скриптов для тестирования производительности PHP
- Тестовое окружение на основе Docker
- Поддержка версий PHP от 7.4 до 8.4
- Различные тестовые сценарии
- Экспорт результатов в различные форматы (CSV, Excel, JSON)

## Требования
- Docker и Docker Compose
- Python 3.8 или выше
- Bash

## Установка

1. Клонируйте репозиторий:
```bash
git clone <repository-url>
cd <repository-directory>
```

2. Запустите скрипт инициализации:
```bash
./init_venv.sh
```

## Использование

### Запуск всех тестов

```bash
./run_report.sh
```

Это запустит контейнеры для версий PHP:
- PHP 7.4 (порт 9022)
- PHP 8.0 (порт 9023)
- PHP 8.1.25 (порт 9024)
- PHP 8.2.12 (порт 9025)
- PHP 8.3 (порт 9026)
- PHP 8.4 (порт 9027)

### Запуск тестов в конкретной директории

```bash
./run_report.sh path/to/test/directory
```

### Экспорт результатов

```bash
# Экспорт в CSV
./run_report.sh path/to/test/directory --csv results.csv

# Экспорт в Excel
./run_report.sh path/to/test/directory --excel results.xlsx

# Экспорт в JSON
./run_report.sh path/to/test/directory --json results.json

# Комбинированный экспорт
./run_report.sh path/to/test/directory --csv results.csv --excel results.xlsx --json results.json
```

## Структура результатов

Результаты группируются по директориям и содержат:
- Время выполнения (ts, sec)
- Использование памяти (memory, GB)

### Формат JSON

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

### Структура тестов
Директория `tests` содержит различные тестовые сценарии:
- `convert_simple_types/` - Тесты производительности преобразования типов
- `curly_braces/` - Тест производительности фигурных скобок
- `foreach_bug/` - Тесты оптимизации циклов foreach