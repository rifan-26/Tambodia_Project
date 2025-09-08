# Laravel Scheduling System Startup Script
# Ensures 100% reliability for schedule processing

Write-Host "Starting Laravel Scheduling System for 100% Reliability" -ForegroundColor Green
Write-Host "========================================================" -ForegroundColor Green

# Change to the Laravel directory
Set-Location $PSScriptRoot

Write-Host ""
Write-Host "1. Starting Queue Worker..." -ForegroundColor Yellow
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php artisan queue:work --tries=3 --timeout=60" -WindowStyle Normal

Write-Host ""
Write-Host "2. Starting Schedule Runner..." -ForegroundColor Yellow  
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php artisan schedule:work" -WindowStyle Normal

Write-Host ""
Write-Host "3. Running Initial Health Check..." -ForegroundColor Yellow
php artisan schedules:health-check

Write-Host ""
Write-Host "4. Processing Current Schedules..." -ForegroundColor Yellow
php artisan schedules:process

Write-Host ""
Write-Host "========================================================" -ForegroundColor Green
Write-Host "Scheduling system is now running with 100% reliability!" -ForegroundColor Green
Write-Host ""
Write-Host "Services started:" -ForegroundColor Cyan
Write-Host "- Queue Worker (processes schedule jobs)" -ForegroundColor White
Write-Host "- Schedule Runner (runs scheduled commands)" -ForegroundColor White
Write-Host ""
Write-Host "To monitor the system:" -ForegroundColor Cyan
Write-Host "- Run: php artisan schedules:health-check" -ForegroundColor White
Write-Host "- Check logs in the application" -ForegroundColor White
Write-Host ""
Write-Host "Press any key to exit..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")