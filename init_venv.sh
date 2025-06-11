#!/bin/bash

# Проверяем наличие python3
if ! command -v python3 &> /dev/null; then
    echo "Python 3 не установлен. Пожалуйста, установите Python 3."
    exit 1
fi

# Проверяем наличие venv
if ! python3 -c "import venv" &> /dev/null; then
    echo "Модуль venv не установлен. Установите его с помощью:"
    echo "sudo apt-get install python3-venv"
    exit 1
fi

# Создаем виртуальное окружение, если его нет
if [ ! -d ".venv" ]; then
    echo "Создаем виртуальное окружение..."
    python3 -m venv .venv
fi

# Активируем виртуальное окружение
echo "Активируем виртуальное окружение..."
source .venv/bin/activate

# Обновляем pip
echo "Обновляем pip..."
pip install --upgrade pip

# Проверяем необходимость обновления пакетов
echo "Проверяем зависимости..."
NEED_UPDATE=false
while IFS= read -r line || [ -n "$line" ]; do
    if [[ $line =~ ^([^=]+)==([0-9.]+)$ ]]; then
        package="${BASH_REMATCH[1]}"
        version="${BASH_REMATCH[2]}"
        if ! pip show "$package" 2>/dev/null | grep -q "Version: $version" 2>/dev/null; then
            NEED_UPDATE=true
            break
        fi
    fi
done < requirements.txt

if [ "$NEED_UPDATE" = true ]; then
    echo "Обновляем зависимости..."
    pip install --upgrade -r requirements.txt
else
    echo "Все зависимости актуальны"
fi

# Деактивируем виртуальное окружение
deactivate

echo "Виртуальное окружение успешно создано и настроено!"
echo "Для активации окружения выполните: source .venv/bin/activate" 