@echo off
echo Starting Optimized Laravel Scheduling System
echo ============================================

echo.
echo 1. Starting Queue Worker (optimized)...
start "Queue Worker" cmd /k "php artisan queue:work --tries=2 --timeout=30 --sleep=3"

echo.
echo 2. Starting Schedule Runner...
start "Schedule Runner" cmd /k "php artisan schedule:work"

echo.
echo 3. Processing Current Schedules...
php artisan schedules:process

echo.
echo ============================================
echo Scheduling system started successfully!
echo.
echo Services running:
echo - Queue Worker (2 retries, 30s timeout)
echo - Schedule Runner (every minute)
echo.
echo Monitor: php artisan schedules:health-check
echo.
echo Press any key to exit...
pause >nul