# Регламент сопровождения проекта super-lawyer

---

## 1. Структура проекта и окружения

| Окружение       | Путь проекта на сервере                             | Ветка GitHub    | Скрипт деплоя              |
|-----------------|----------------------------------------------------|-----------------|----------------------------|
| Локальная машина| `R:\www\jurist\dev`                                | develop (локально) | —                          |
| Тестовый сервер | `/var/www/www-root/data/www/test.super-lawyer.ru` | develop         | `scripts/deploy_test.sh`   |
| Боевой сервер   | `/var/www/www-root/data/www/super-lawyer.ru`      | main            | `scripts/deploy_prod.sh`   |

---

## 2. Настройка репозитория

- Создать репозиторий `super-lawyer` на GitHub.
- Создать две ветки: `main` (для продакшн) и `develop` (для разработки).
- Клонировать проект на локальной машине и серверах.
- На локальной машине вести работу в ветке `develop`, пушить изменения туда.
- Проводить тестирование на тестовом сервере.
- После успешной проверки сливать изменения из `develop` в `main` и деплоить на боевой сервер.

---

## 3. Работа с SSH

- Генерировать SSH-ключ с именем `id_ed25519_vhs` (без пароля для автоматизации).
- Добавить публичный ключ в `~/.ssh/authorized_keys` на серверах.
- Настроить SSH-доступ с локальной машины к серверам и GitHub.
- Добавить в Git конфигурацию для разрешения работы с директориями на серверах:
  ```
  git config --global --add safe.directory /путь/к/проекту
  ```

---

## 4. Скрипты деплоя

### 4.1 Расположение и права

- Создать папку `scripts/` на каждом сервере в корне проекта.
- Поместить скрипты деплоя в эту папку:
  - `deploy_test.sh` — для тестового сервера.
  - `deploy_prod.sh` — для продакшн-сервера.
- Сделать скрипты исполняемыми:  
  ```bash
  chmod +x scripts/deploy_*.sh
  ```
- Добавить в `.gitignore` корня проекта строку:
  ```
  /scripts/deploy_*.sh
  ```
  чтобы скрипты не попадали в репозиторий.

### 4.2 Скрипт для тестового сервера (`deploy_test.sh`)

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

### 4.3 Скрипт для продакшн-сервера (`deploy_prod.sh`)

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
chown -R www-data:www-data backend/runtime backend/web/assets                    console/runtime                    frontend/runtime frontend/web/assets
chmod -R 775 backend/runtime backend/web/assets               console/runtime               frontend/runtime frontend/web/assets

echo "✅ Deploy complete."
```

---

## 5. Пошаговый алгоритм работы над проектом

1. **Локальная разработка**
   - Работать в ветке `develop`.
   - Коммитить и пушить изменения в ветку `develop`.
2. **Деплой на тестовый сервер**
   - Подключиться к тестовому серверу.
   - Запустить скрипт:  
     ```
     ./scripts/deploy_test.sh
     ```
   - Проверить корректность работы сайта на `test.super-lawyer.ru`.
3. **Перенос на продакшн**
   - Слить изменения из ветки `develop` в `main` на GitHub.
   - Подключиться к продакшн-серверу.
   - Запустить скрипт:  
     ```
     ./scripts/deploy_prod.sh
     ```
   - Проверить работу сайта на `super-lawyer.ru`.

---

## 6. Важные рекомендации

- Никогда не менять скрипты деплоя вручную без фиксации в регламенте.
- Всегда тестировать изменения на тестовом сервере.
- Проверять права доступа для папок `runtime` и `web/assets` после деплоя.
- Использовать `git config --global --add safe.directory` для избежания ошибок безопасности Git.
- Контролировать доступ через SSH-ключи без пароля для автоматизации.
- Не запускать Composer как root без необходимости (использовать переменную `COMPOSER_ALLOW_SUPERUSER=1` с осторожностью).

---

# Конец регламента
