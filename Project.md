# Регламент сопровождения проекта super-lawyer

---

## 1. Структура проекта и окружения

| Окружение        | Путь проекта на сервере                           | Ветка GitHub       | Скрипт деплоя            |
|------------------|---------------------------------------------------|--------------------|--------------------------|
| Локальная машина | `R:\www\jurist\dev`                               | develop (локально) | —                        |
| Тестовый сервер  | `/var/www/www-root/data/www/test.super-lawyer.ru` | develop            | `scripts/deploy_test.sh` |
| Боевой сервер    | `/var/www/www-root/data/www/super-lawyer.ru`      | main               | `scripts/deploy_prod.sh` |

---

## 2. Настройка репозитория

- На GitHub создать репозиторий `super-lawyer`.
- Создать ветки `main` (prod) и `develop` (dev).
- Клонировать проект на сервера и локально.
- На локальной машине работать в ветке `develop`, пушить изменения туда.
- Тестировать на тестовом сервере.
- После проверки сливать изменения в ветку `main` и деплоить на прод.

---

## 3. Работа с SSH

- Использовать ключ с именем `id_ed25519_vhs`.
- Ключ должен быть без пароля (для автодеплоя).
- На серверах добавить ключ в `~/.ssh/authorized_keys`.
- На локальной машине — настроить SSH для GitHub.

---

## 4. Скрипты деплоя

### 4.1 Расположение и права

- Скрипты лежат в папке `scripts/` на каждом сервере.
- Файлы `deploy_test.sh` и `deploy_prod.sh` исполняемые (`chmod +x`).
- В `.gitignore` добавлена строка `/scripts/deploy_*.sh` для исключения из репо.

### 4.2 Тестовый деплой (`deploy_test.sh`)

```bash
#!/bin/bash

echo "🔄 Resetting to origin/develop..."
git fetch origin
git reset --hard origin/develop || exit 1

echo "📦 Installing composer dependencies..."
composer install --no-interaction --prefer-dist || exit 1

echo "🔃 Running migrations..."
php yii migrate --interactive=0 || exit 1

echo "✅ Deploy complete."
```

### 4.3 Продакшн деплой (deploy_prod.sh)

```bash
#!/bin/bash
echo "🔄 Resetting to origin/main..."
git fetch origin
git reset --hard origin/main || exit 1

echo "📦 Installing composer dependencies..."
export COMPOSER_ALLOW_SUPERUSER=1
composer install --no-dev --no-interaction --prefer-dist || exit 1

echo "🔃 Running migrations..."
php yii migrate --interactive=0 || exit 1

echo "🔐 Fixing permissions..."
chown -R www-data:www-data backend/runtime backend/web/assets \
                   console/runtime \
                   frontend/runtime frontend/web/assets
chmod -R 775 backend/runtime backend/web/assets \
              console/runtime \
              frontend/runtime frontend/web/assets

echo "✅ Deploy complete."
```

---

### 5. Алгоритм работы над проектом

- Локальная разработка
- Работа в ветке develop.
- Коммит и пуш изменений в ветку develop.
- Деплой на тестовый сервер
- Подключиться к тестовому серверу.
- Запустить ./scripts/deploy_test.sh.
- Проверить работу сайта на test.super-lawyer.ru.
- Перенос на продакшн
- Слить изменения из develop в main на GitHub.
  - git checkout main
  - git merge develop
  - git push origin main 
- Подключиться к продакшн-серверу.
- Запустить ./scripts/deploy_prod.sh.
- Проверить работу сайта на super-lawyer.ru.

---

### 6. Важные рекомендации

- Никогда не менять скрипты деплоя вручную на серверах без фиксации в регламенте.
- Всегда тестировать изменения на тестовом сервере перед переносом на прод.
- Настроить права доступа к папкам runtime и web/assets согласно скриптам.
- Использовать git config --global --add safe.directory <путь> на серверах для избежания ошибок безопасности Git.
- Контроль доступа через SSH-ключи без пароля для автоматизации деплоя.

---

### 7. Иконки для услуг
📚 Где взять эти иконки?
Официальный сайт: https://icons.getbootstrap.com

Там можно выбрать подходящий символ, кликнуть, и скопировать имя класса.

