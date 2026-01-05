# WaoBiz Backup Script
# Creates backups of database and important files

param(
    [string]$BackupPath = "C:\Backups\WaoBiz",
    [switch]$DatabaseOnly = $false,
    [switch]$FilesOnly = $false
)

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  WaoBiz Backup Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$ProjectPath = "C:\inetpub\wwwroot\waobiz_web"
$Timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$ErrorActionPreference = "Stop"

try {
    # Create backup directory if it doesn't exist
    if (-not (Test-Path $BackupPath)) {
        New-Item -ItemType Directory -Path $BackupPath -Force | Out-Null
        Write-Host "Created backup directory: $BackupPath" -ForegroundColor Green
    }

    Set-Location $ProjectPath

    # Database Backup
    if (-not $FilesOnly) {
        Write-Host "[1/3] Creating database backup..." -ForegroundColor Yellow

        # Using Laravel backup command
        php artisan backup:run --only-db 2>&1 | Out-Null

        # Alternative: Direct mysqldump
        $dbName = "waobiz"
        $dbUser = "WaoBiz"
        $dbPass = "Possible@2026"
        $backupFile = "$BackupPath\waobiz_db_$Timestamp.sql"

        Write-Host "  Backing up database to: $backupFile" -ForegroundColor Gray
        mysqldump -u $dbUser -p$dbPass $dbName > $backupFile 2>&1

        if (Test-Path $backupFile) {
            $fileSize = (Get-Item $backupFile).Length / 1MB
            Write-Host "  ✅ Database backup created: $([math]::Round($fileSize, 2)) MB" -ForegroundColor Green
        }
    }

    # Files Backup
    if (-not $DatabaseOnly) {
        Write-Host "[2/3] Creating files backup..." -ForegroundColor Yellow

        $filesBackupPath = "$BackupPath\waobiz_files_$Timestamp.zip"

        # Backup important directories
        $itemsToBackup = @(
            "storage/app",
            "public/uploads",
            ".env"
        )

        Write-Host "  Creating compressed archive..." -ForegroundColor Gray
        Compress-Archive -Path $itemsToBackup -DestinationPath $filesBackupPath -Force -ErrorAction SilentlyContinue

        if (Test-Path $filesBackupPath) {
            $fileSize = (Get-Item $filesBackupPath).Length / 1MB
            Write-Host "  ✅ Files backup created: $([math]::Round($fileSize, 2)) MB" -ForegroundColor Green
        }
    }

    # Cleanup old backups (keep last 7 days)
    Write-Host "[3/3] Cleaning up old backups..." -ForegroundColor Yellow
    $cutoffDate = (Get-Date).AddDays(-7)
    Get-ChildItem -Path $BackupPath -File | Where-Object { $_.LastWriteTime -lt $cutoffDate } | ForEach-Object {
        Remove-Item $_.FullName -Force
        Write-Host "  Removed old backup: $($_.Name)" -ForegroundColor Gray
    }

    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  ✅ Backup Completed Successfully!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Backup Location: $BackupPath" -ForegroundColor White
    Write-Host "Timestamp: $Timestamp" -ForegroundColor White
    Write-Host ""

    # List recent backups
    Write-Host "Recent Backups:" -ForegroundColor Cyan
    Get-ChildItem -Path $BackupPath -File | Sort-Object LastWriteTime -Descending | Select-Object -First 5 | ForEach-Object {
        $size = [math]::Round($_.Length / 1MB, 2)
        Write-Host "  - $($_.Name) ($size MB)" -ForegroundColor White
    }

} catch {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "  ❌ Backup Failed!" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
