# WaoBiz Rollback Script
# This script rolls back to a previous Git commit

param(
    [string]$CommitHash = "HEAD~1"
)

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  WaoBiz Rollback Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$ProjectPath = "C:\inetpub\wwwroot\waobiz_web"
$ErrorActionPreference = "Stop"

try {
    Set-Location $ProjectPath

    # Show current commit
    $currentCommit = git rev-parse --short HEAD
    Write-Host "Current commit: $currentCommit" -ForegroundColor Yellow

    # Enable maintenance mode
    Write-Host ""
    Write-Host "Enabling maintenance mode..." -ForegroundColor Yellow
    php artisan down --retry=60

    # Rollback to specified commit
    Write-Host "Rolling back to: $CommitHash" -ForegroundColor Yellow
    git reset --hard $CommitHash

    # Install dependencies
    Write-Host "Installing dependencies..." -ForegroundColor Yellow
    composer install --no-dev --optimize-autoloader --no-interaction

    # Run migrations rollback (optional)
    Write-Host "Rolling back last migration batch..." -ForegroundColor Yellow
    php artisan migrate:rollback --step=1 --force

    # Clear caches
    Write-Host "Clearing caches..." -ForegroundColor Yellow
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear

    # Cache configuration
    php artisan config:cache

    # Restart IIS
    Write-Host "Restarting IIS Application Pool..." -ForegroundColor Yellow
    Import-Module WebAdministration
    Restart-WebAppPool -Name "DefaultAppPool"

    # Disable maintenance mode
    php artisan up

    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  ✅ Rollback Completed Successfully!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Rolled back to commit: $(git rev-parse --short HEAD)" -ForegroundColor White

} catch {
    Write-Host ""
    Write-Host "❌ Rollback Failed: $($_.Exception.Message)" -ForegroundColor Red
    php artisan up
    exit 1
}
