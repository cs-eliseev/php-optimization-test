#!/bin/bash

# Проверяем наличие docker-compose
if command -v docker-compose &> /dev/null; then
    DOCKER_COMPOSE="docker-compose"
elif command -v docker compose &> /dev/null; then
    DOCKER_COMPOSE="docker compose"
else
    echo "Ошибка: docker-compose не найден"
    exit 1
fi

# Инициализируем виртуальное окружение
./init_venv.sh

# Проверяем, запущен ли контейнер
if ! docker ps | grep -q my-php7_4-container; then
    echo "Запускаем контейнеры..."
    $DOCKER_COMPOSE up -d
fi

echo "Активируем виртуальное окружение..."
source .venv/bin/activate

# Запускаем тесты
if [ $# -eq 0 ]; then
    echo "Запускаем все тесты..."
    python3 run_report.py
else
    echo "Запускаем тесты с параметрами: $@"
    python3 run_report.py "$@"
fi

# Деактивируем виртуальное окружение
deactivate 