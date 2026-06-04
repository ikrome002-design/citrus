# Citrus Version 0

## Overview

Citrus Version 0 is a Laravel-based e-commerce application. It includes customer-facing storefront pages, admin and staff dashboards, product/catalog management, order workflows, payment provider configuration, email configuration, and asset compilation through Laravel Mix.

This repository has been repaired for safe local development and GitHub readiness. Secrets must stay in a local `.env` file and must not be committed.

## Detected Tech Stack

- Backend: Laravel 5.7 application running on PHP 7.4
- Frontend: Blade templates, Bootstrap, jQuery, Vue 2 dependency, AdminLTE, Select2, DataTables
- Database: MySQL, with MySQL 5.7 declared in `docker-compose.yml`
- Runtime: PHP 7.4, Node.js 24
- Package manager: Composer 2, npm 11
- Build tool: Laravel Mix 6, Webpack 5
- Test framework: PHPUnit 7

## Prerequisites

- PHP 7.4 with these extensions enabled:
  - `gd`
  - `json`
  - `pdo_mysql`
  - `pdo_sqlite`
  - `sqlite3`
- Composer 2
- Node.js 24
- npm 11
- MySQL 5.7 or a compatible local MySQL server
- Docker and Docker Compose, optional for the declared MySQL/nginx/app stack

Verified local versions during repair:

```bash
node -v
# v24.15.0

npm -v
# 11.12.1

php -v
# PHP 7.4.33
```

On the verified Windows workstation, PHP 7.4 is available at:

```powershell
C:\Users\nderu\dev-tools\php74\php.exe
```

The global Composer launcher on that workstation uses PHP 8.5, so Composer commands for this project should be run through PHP 7.4:

```powershell
& 'C:\Users\nderu\dev-tools\php74\php.exe' 'C:\Users\nderu\dev-tools\composer\composer.phar' --version
```

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/ikrome002-design/citrus.git
cd citrus
git checkout legacy/v0
```

### 2. Create local environment file

```bash
cp .env.example .env
```

PowerShell equivalent:

```powershell
Copy-Item .env.example .env
```

Then update `.env` with local, real values. Do not commit `.env`.

At minimum, confirm:

- `APP_URL=http://127.0.0.1:8000`
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=citrus_v0`
- `DB_USERNAME` and `DB_PASSWORD` match your local database

Generate a local app key if `APP_KEY` is empty:

```bash
php artisan key:generate
```

PowerShell with the verified PHP 7.4 binary:

```powershell
& 'C:\Users\nderu\dev-tools\php74\php.exe' artisan key:generate
```

### 3. Install PHP dependencies

Use PHP 7.4 for Composer operations.

```bash
composer install
```

PowerShell with the verified PHP 7.4 binary:

```powershell
& 'C:\Users\nderu\dev-tools\php74\php.exe' 'C:\Users\nderu\dev-tools\composer\composer.phar' install
```

### 4. Install Node dependencies

```bash
npm install
```

PowerShell may block `npm.ps1`; this form was verified:

```powershell
cmd /c npm install
```

### 5. Prepare the database

Create a MySQL database matching `.env`, for example `citrus_v0`.

Run migrations:

```bash
php artisan migrate
```

PowerShell with the verified PHP 7.4 binary:

```powershell
& 'C:\Users\nderu\dev-tools\php74\php.exe' artisan migrate
```

The local repair pass verified that the existing database connection works and that migrations were already applied in the repaired workspace.

### 6. Build frontend assets

Development build:

```bash
npm run dev
```

Production build:

```bash
npm run production
```

PowerShell verified form:

```powershell
cmd /c npm run dev
cmd /c npm run production
```

### 7. Run locally

The verified local runtime command was:

```bash
php -S 127.0.0.1:8000 server.php
```

PowerShell with the verified PHP 7.4 binary:

```powershell
& 'C:\Users\nderu\dev-tools\php74\php.exe' -S 127.0.0.1:8000 server.php
```

Open:

```text
http://127.0.0.1:8000/
```

Verified routes during repair:

- `/`
- `/login`
- `/register`

## Docker Notes

`docker-compose.yml` declares:

- app service built from `Dockerfile`
- nginx webserver on port `8000`
- MySQL 5.7 on port `3306`

The Docker Compose configuration was validated with:

```bash
docker compose config
```

Result: configuration parsed successfully. Docker emitted a warning that the Compose `version` field is obsolete.

## Quality Commands

Available npm scripts:

```bash
npm run dev
npm run production
npm run prod
npm run watch
npm run watch-poll
npm run hot
```

Verified build and dependency commands:

```bash
npm ls --depth=0
npm run dev
npm run production
npm run prod
```

PowerShell verified form:

```powershell
cmd /c npm ls --depth=0
cmd /c npm run dev
cmd /c npm run production
cmd /c npm run prod
```

Composer checks:

```bash
composer validate --strict
composer check-platform-reqs
```

Use PHP 7.4 for Composer on systems where the default PHP is newer than 7.4.

PHPUnit:

```bash
vendor/phpunit/phpunit/phpunit --colors=never
```

PowerShell with the verified PHP 7.4 binary:

```powershell
& 'C:\Users\nderu\dev-tools\php74\php.exe' vendor\phpunit\phpunit\phpunit --colors=never
```

`php artisan test` is not available in this Laravel 5.7 application.

## Current QA Status

Passing checks from the repair pass:

- `npm ls --depth=0`
- `npm run dev`
- `npm run production`
- `npm run prod`
- `composer check-platform-reqs`
- `docker compose config`
- Browser smoke test for the homepage with local assets

Known non-passing checks:

- `composer validate --strict` reports warnings for dependency constraints:
  - `paypal/rest-api-sdk-php` uses an unbound `*` constraint
  - `stripe/stripe-php` is pinned exactly to `5.0`
- Full PHPUnit currently runs but is not green:
  - `327 tests`
  - `561 assertions`
  - `54 errors`
  - `132 failures`

Major proven PHPUnit failure categories:

- Admin tests expect routes named `admin.employees.*`, while the application currently registers `admin.staffs.*`.
- Order status tests expect `admin.order-statuses.*`, while the application currently registers `admin.order-status.*`.
- Many admin feature tests receive `403` because test users are not aligned with the `superadmin` route middleware.
- Some repository and frontend tests no longer match current application behavior and need focused follow-up repair.

## Security And GitHub Readiness

- Do not commit `.env`.
- Use `.env.example` for placeholders only.
- Do not place real API keys, access tokens, passwords, OAuth secrets, payment secrets, or mail provider credentials in tracked files.
- If any real secret was ever committed or shared, rotate it before pushing to GitHub.
- Keep generated runtime files, uploaded media, local storage output, caches, and dependency folders out of Git.
- The repository currently contains staged cleanup to remove sensitive or unnecessary tracked runtime files.

Before committing, review:

```bash
git status
git diff --cached --stat
git diff --cached
```

The branch verified during repair was:

```text
legacy/v0
```

It was ahead of and behind `origin/legacy/v0`, so synchronize intentionally before pushing.

## License

The original upstream project declared the MIT license in `composer.json`.
