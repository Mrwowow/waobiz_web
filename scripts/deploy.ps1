# WaoBiz Deployment Script for Windows/IIS
# This script automates the deployment process

param(
    [string]$Environment = "production",
    [switch]$SkipMigrations = $false
)

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  WaoBiz Deployment Script" -ForegroundColor Cyan
Write-Host "  Environment: $Environment" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$ProjectPath = "C:\inetpub\wwwroot\waobiz_web"
$ErrorActionPreference = "Stop"

try {
    # Change to project directory
    Write-Host "[1/10] Navigating to project directory..." -ForegroundColor Yellow
    Set-Location $ProjectPath

    # Enable maintenance mode
    Write-Host "[2/10] Enabling maintenance mode..." -ForegroundColor Yellow
    php artisan down --retry=60 --secret="waobiz-deploy-secret"

    # Pull latest changes from Git
    Write-Host "[3/10] Pulling latest changes from Git..." -ForegroundColor Yellow
    git fetch origin main
    git reset --hard origin/main

    # Install/Update Composer dependencies
    Write-Host "[4/10] Installing Composer dependencies..." -ForegroundColor Yellow
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

    # Clear all caches
    Write-Host "[5/10] Clearing application caches..." -ForegroundColor Yellow
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    php artisan event:clear

    # Run database migrations
    if (-not $SkipMigrations) {
        Write-Host "[6/10] Running database migrations..." -ForegroundColor Yellow
        php artisan migrate --force
    } else {
        Write-Host "[6/10] Skipping database migrations..." -ForegroundColor Gray
    }

    # Cache configuration and routes
    Write-Host "[7/10] Caching configuration and routes..." -ForegroundColor Yellow
    php artisan config:cache
    php artisan event:cache

    # Set proper permissions
    Write-Host "[8/10] Setting directory permissions..." -ForegroundColor Yellow
    icacls storage /grant "IIS_IUSRS:(OI)(CI)F" /T
    icacls bootstrap\cache /grant "IIS_IUSRS:(OI)(CI)F" /T

    # Restart IIS Application Pool
    Write-Host "[9/10] Restarting IIS Application Pool..." -ForegroundColor Yellow
    Import-Module WebAdministration
    Restart-WebAppPool -Name "DefaultAppPool"

    # Disable maintenance mode
    Write-Host "[10/10] Disabling maintenance mode..." -ForegroundColor Yellow
    php artisan up

    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  ✅ Deployment Completed Successfully!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""

    # Show deployment info
    Write-Host "Deployment Information:" -ForegroundColor Cyan
    Write-Host "  - Git Commit: $(git rev-parse --short HEAD)" -ForegroundColor White
    Write-Host "  - Branch: $(git branch --show-current)" -ForegroundColor White
    Write-Host "  - Deployed at: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')" -ForegroundColor White
    Write-Host ""

} catch {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "  ❌ Deployment Failed!" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red

    # Try to disable maintenance mode even on failure
    Write-Host ""
    Write-Host "Attempting to disable maintenance mode..." -ForegroundColor Yellow
    php artisan up

    exit 1
}
