# Citrus

## Overview

Citrus is a Laravel commerce-style application with storefront, admin, and merchant/business areas. The repaired local setup currently verifies the admin and merchant login surfaces without requiring a running database; storefront pages are database-backed and require MySQL data before they can render successfully.

## Detected Tech Stack

- Backend: Laravel 10.50.2 on PHP
- Frontend: Blade templates with Vite-managed Sass and JavaScript assets
- Database: MySQL
- Runtime: PHP 8.4.21, Node.js 24.15.0
- Package manager: Composer 2.9.8, npm 11.12.1
- Build tool: Vite 4.5.14
- Tests/style: PHPUnit 10, Laravel Pint

## Prerequisites

Install or provide:

- PHP `^8.1`; this workspace was validated with PHP `8.4.21`
- Composer `2.x`; this workspace was validated with Composer `2.9.8`
- Node.js and npm; this workspace was validated with Node `24.15.0` and npm `11.12.1`
- MySQL on `127.0.0.1:3306`
- PHP extensions required by the lock file, including `bcmath`, `curl`, `dom`, `fileinfo`, `gd`, `openssl`, `pdo`, `session`, `simplexml`, `xml`, `xmlreader`, `xmlwriter`, `zip`, and `zlib`

Do not use PHP `8.5` with the current lock file. The installed `phpoffice/phpspreadsheet` dependency blocks PHP `>=8.5`.

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/ikrome002-design/citrus.git
cd citrus
```

### 2. Install PHP dependencies

If Composer is available on `PATH`:

```bash
composer install
```

The repaired Windows workspace used this explicit command:

```powershell
& "C:\Users\nderu\dev-tools\php\php.exe" C:\ProgramData\ComposerSetup\bin\composer.phar install
```

### 3. Install Node dependencies

```bash
npm ci
```

On Windows PowerShell, if `npm.ps1` is blocked by execution policy, use:

```powershell
npm.cmd ci
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Use placeholder-safe values in `.env.example`; do not commit real values. The repaired local domain configuration uses:

```env
APP_DOMAIN=lvh.me
APP_URL=http://${APP_DOMAIN}
ADMIN_URL=http://admin.${APP_DOMAIN}
BUSINESS_URL=http://business.${APP_DOMAIN}
SESSION_DRIVER=file
```

`lvh.me`, `admin.lvh.me`, and `business.lvh.me` resolve to `127.0.0.1`, so no hosts-file edit is required.

Configure local MySQL separately:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

The database name, username, and password are intentionally blank in `.env.example`. Fill them only in local `.env`.

### 5. Build frontend assets

```bash
npm run build
```

On Windows PowerShell:

```powershell
npm.cmd run build
```

### 6. Clear Laravel caches

```bash
php artisan optimize:clear
```

The repaired Windows workspace used:

```powershell
& "C:\Users\nderu\dev-tools\php\php.exe" artisan optimize:clear
```

### 7. Run locally

Standard Laravel command:

```bash
php artisan serve --host=127.0.0.1 --port=8001
```

For this Windows workspace, PHP 8.4 deprecation notices from legacy dependencies can appear in rendered pages when using `artisan serve`. The verified workaround is to run the PHP built-in server from the `public` directory with `display_errors=Off` and the Laravel router path.

```powershell
cd "C:\Users\nderu\Documents\Development\Product\Citrus\Users\Version 1\public"
& "C:\Users\nderu\dev-tools\php\php.exe" -d display_errors=Off -S 127.0.0.1:8001 C:\Users\nderu\DOCUME~1\DEVELO~1\Product\Citrus\Users\VERSIO~1\vendor\laravel\FRAMEW~1\src\ILLUMI~1\FOUNDA~1\RESOUR~1\server.php
```

Verified local URLs:

- `http://admin.lvh.me:8001/`
- `http://business.lvh.me:8001/`
- `http://lvh.me:8001/`

The admin and merchant login pages were verified to render. The storefront root requires a reachable MySQL database and currently returns `500` when MySQL is unavailable.

## Quality Commands

Validated commands:

```powershell
& "C:\Users\nderu\dev-tools\php\php.exe" C:\ProgramData\ComposerSetup\bin\composer.phar validate --strict
& "C:\Users\nderu\dev-tools\php\php.exe" C:\ProgramData\ComposerSetup\bin\composer.phar check-platform-reqs --lock
npm.cmd run build
& "C:\Users\nderu\dev-tools\php\php.exe" artisan test
& "C:\Users\nderu\dev-tools\php\php.exe" vendor\bin\phpunit
& "C:\Users\nderu\dev-tools\php\php.exe" vendor\bin\pint --test --dirty
```

Latest Phase 6 results:

- Composer validation: pass
- Composer platform requirements: pass
- Vite production build: pass
- Laravel tests: pass, `3` tests and `5` assertions
- PHPUnit: pass, `3` tests and `5` assertions, with one PHPUnit schema deprecation
- Pint dirty-file style check: pass

## Security And Dependency Status

Known unresolved findings from the final audit:

- `composer audit` reports advisories affecting `knplabs/knp-snappy` and `laravel/framework`.
- `composer audit` reports `mailchimp/mailchimp` as abandoned.
- `npm audit --audit-level=moderate` reports advisories in CKEditor and Vite/esbuild-related packages.
- Available npm fixes require breaking upgrades, so they were not applied during the repair phase.
- Legacy PayPal REST SDK usage remains a compatibility risk and needs modernization before PayPal checkout can be considered verified.
- `laravel/helpers` emits PHP 8.4 deprecation notices.
- Vite/Sass build emits a legacy JS API deprecation warning.

Do not treat the repository as production-secure until the audit findings are resolved and retested.

## GitHub Readiness

Safe-to-commit hygiene completed:

- `.env` is ignored and must not be committed.
- `.env.example` contains placeholders only.
- Generated helper files, local SQL dumps, runtime storage artifacts, profile uploads, and backup files were removed from Git tracking.
- Dependencies are represented by lock files; do not commit `vendor/` or `node_modules/`.

Before pushing to GitHub:

```bash
git status
git diff --cached --stat
git diff --cached --check
```

Review the staged deletion list carefully. The cleanup intentionally removes generated and local-only files from Git tracking, but local copies may still exist in the working directory.

## Current Limitations

- Storefront pages require MySQL. In the repaired workspace, `MySQL57` was stopped and could not be started from the current session.
- No CI workflow is present in `.github/workflows`.
- No npm lint, npm test, or TypeScript typecheck script is defined in `package.json`.
- The test suite is currently a smoke-test baseline for the login surfaces, not full business-logic coverage.
