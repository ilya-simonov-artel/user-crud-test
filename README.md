# Laravel User CRUD

## Использование проекта

### Требования
- PHP 8.1+
- Composer
- Node.js и npm
- База данных (MySQL/MariaDB/PostgreSQL)

### Быстрый старт
1) Установить зависимости.
```bash
composer install
npm install
```

2) Подготовить окружение.
```bash
cp .env.example .env
php artisan key:generate
```

3) Настроить базу в `.env` и выполнить миграции/сиды.
```bash
php artisan migrate
php artisan db:seed
```

4) Создать симлинк для storage.
```bash
php artisan storage:link
```

5) Собрать фронтенд.
```bash
npm run build
```

6) Запустить проект.
```bash
php artisan serve
```

### Локальный запуск через Sail (Docker)
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
./vendor/bin/sail artisan storage:link
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### Доступ
- Главная: `GET /`
- Вход: `GET /login`
- Профиль: `GET /profile/{user}`
- Редактирование профиля: `GET /profile/{user}/edit`
- Админ пользователи: `GET /admin/users`

### Демо-аккаунты (сидер)
- Админ: `user@example.com` / `password`
- Пользователь: `simple_user@example.com` / `password_for_simple_user`

### Тесты
```bash
php artisan test
```
