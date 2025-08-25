---
description: Repository Information Overview
alwaysApply: true
---

# Tambodia Project Information

## Summary
Tambodia is a Laravel-based web application for media management with role-based access control. It features a public landing page, employee dashboard for media uploads, and a superadmin dashboard for user management and activity logging.

## Structure
- **app/**: Core application code (Controllers, Models, Middleware)
- **bootstrap/**: Framework bootstrap files
- **config/**: Configuration files
- **database/**: Database migrations and seeders
- **public/**: Publicly accessible files
- **resources/**: Views, assets, and language files
- **routes/**: Application routes
- **storage/**: File uploads, logs, and cache
- **tests/**: Application tests

## Language & Runtime
**Language**: PHP
**Version**: ^8.2
**Framework**: Laravel ^12.0
**Build System**: Composer
**Package Manager**: Composer (PHP), npm (JavaScript)

## Dependencies
**Main Dependencies**:
- laravel/framework: ^12.0
- laravel/tinker: ^2.10.1

**Development Dependencies**:
- fakerphp/faker: ^1.23
- laravel/pail: ^1.2.2
- laravel/pint: ^1.13
- laravel/sail: ^1.41
- mockery/mockery: ^1.6
- nunomaduro/collision: ^8.6
- phpunit/phpunit: ^11.5.3
- tailwindcss: ^4.0.0
- vite: ^7.0.4

## Build & Installation
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run database migrations
php artisan migrate

# Build frontend assets
npm run build
```

## Docker
**Configuration**: Laravel Sail is included as a development dependency, providing Docker-based development environment.

**Setup Command**:
```bash
# Start Docker environment
php artisan sail:install
./vendor/bin/sail up
```

## Testing
**Framework**: PHPUnit
**Test Location**: tests/Feature and tests/Unit
**Configuration**: phpunit.xml
**Run Command**:
```bash
php artisan test
# or
composer test
```

## Application Structure
**Models**:
- User: Authentication and user management
- AdminUser: Superadmin functionality
- Media: Media file management
- Schedule: Media scheduling
- Log: Activity logging

**Controllers**:
- AuthController: Authentication
- DashboardController: Dashboard views
- MediaController: Media management
- ScheduleController: Media scheduling
- SuperAdminController: User management
- LandingController: Public landing page

**Middleware**:
- RoleMiddleware: Role-based access control
- SuperadminMiddleware: Superadmin access
- PegawaiMiddleware: Employee access
- XSSProtection: Security middleware
- ContentSecurityPolicy: Security middleware

## Frontend
**Framework**: TailwindCSS
**Build Tool**: Vite
**Commands**:
```bash
# Development
npm run dev

# Production build
npm run build
```

## Development Workflow
```bash
# Start development server with hot reload
composer dev
# This runs Laravel server, queue worker, logs, and Vite
```