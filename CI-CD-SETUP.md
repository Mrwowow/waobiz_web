# WaoBiz CI/CD Pipeline Setup Guide

## Overview

This document explains the CI/CD (Continuous Integration/Continuous Deployment) pipeline setup for the WaoBiz Laravel application using GitHub Actions.

## 📋 Table of Contents

- [Workflows](#workflows)
- [GitHub Secrets Configuration](#github-secrets-configuration)
- [Deployment Process](#deployment-process)
- [Manual Deployment](#manual-deployment)
- [Rollback Procedure](#rollback-procedure)
- [Troubleshooting](#troubleshooting)

## 🔄 Workflows

### 1. CI Workflow (`.github/workflows/ci.yml`)

**Triggers:** Push or Pull Request to `main` or `develop` branches

**What it does:**
- ✅ Checks PHP syntax errors
- ✅ Runs code style checks (Laravel Pint)
- ✅ Security vulnerability audit
- ✅ Builds frontend assets
- ✅ Caches dependencies for faster builds

### 2. CD Deployment Workflow (`.github/workflows/deploy.yml`)

**Triggers:** Push to `main` branch or manual trigger

**What it does:**
- ✅ Deploys code to production server
- ✅ Runs database migrations
- ✅ Clears and caches configurations
- ✅ Restarts IIS Application Pool
- ✅ Performs health checks

### 3. Manual Deployment (`.github/workflows/manual-deploy.yml`)

**Triggers:** Manual workflow dispatch

**What it does:**
- ✅ Allows controlled deployments
- ✅ Option to skip migrations
- ✅ Choose target environment
- ✅ Provides deployment instructions

## 🔐 GitHub Secrets Configuration

### Required Secrets

You need to configure the following secrets in your GitHub repository:

1. Go to: `https://github.com/Mrwowow/waobiz_web/settings/secrets/actions`
2. Click **"New repository secret"**
3. Add each of the following:

| Secret Name | Description | Example Value |
|-------------|-------------|---------------|
| `SERVER_HOST` | Server IP or hostname | `69.169.97.118` or `waobiz.app` |
| `SERVER_USER` | SSH/Admin username | `Administrator` |
| `SERVER_PASSWORD` | Server password | `YourSecurePassword` |
| `SERVER_PATH` | Full path to application | `C:\inetpub\wwwroot\waobiz_web` |
| `SSH_PRIVATE_KEY` | SSH private key (if using SSH) | Contents of private key file |
| `FTP_SERVER` | FTP server (if using FTP) | `ftp.waobiz.app` |
| `FTP_USERNAME` | FTP username | `ftpuser` |
| `FTP_PASSWORD` | FTP password | `FtpPassword123` |
| `FTP_SERVER_DIR` | FTP directory path | `/httpdocs/` |

### How to Add Secrets

```bash
# Navigate to your repository on GitHub
# Settings → Secrets and variables → Actions → New repository secret
```

## 🚀 Deployment Process

### Automatic Deployment

When you push to the `main` branch:

1. Code is pushed to GitHub
2. CI workflow runs tests and checks
3. If tests pass, deployment workflow triggers
4. Application is deployed to production
5. Health checks verify deployment
6. Notification of success/failure

### Manual Server Deployment

If you prefer to deploy directly on the server:

```powershell
# Navigate to project directory
cd C:\inetpub\wwwroot\waobiz_web

# Run deployment script
powershell -ExecutionPolicy Bypass -File scripts\deploy.ps1

# Or with specific options
powershell -ExecutionPolicy Bypass -File scripts\deploy.ps1 -SkipMigrations
```

## 🔄 Manual Deployment via GitHub

1. Go to: `https://github.com/Mrwowow/waobiz_web/actions`
2. Click on **"Manual Deployment"** workflow
3. Click **"Run workflow"** button
4. Choose options:
   - Environment: `production` or `staging`
   - Skip migrations: `true` or `false`
5. Click **"Run workflow"**

## ⏮️ Rollback Procedure

If something goes wrong with a deployment, you can rollback:

### Method 1: Using Rollback Script

```powershell
cd C:\inetpub\wwwroot\waobiz_web

# Rollback to previous commit
powershell -ExecutionPolicy Bypass -File scripts\rollback.ps1

# Rollback to specific commit
powershell -ExecutionPolicy Bypass -File scripts\rollback.ps1 -CommitHash abc123
```

### Method 2: Manual Git Rollback

```powershell
cd C:\inetpub\wwwroot\waobiz_web

# Enable maintenance mode
php artisan down

# Rollback to previous commit
git reset --hard HEAD~1

# Install dependencies
composer install --no-dev --optimize-autoloader

# Rollback migrations (if needed)
php artisan migrate:rollback --step=1

# Clear caches
php artisan cache:clear
php artisan config:cache

# Restart IIS
Restart-WebAppPool -Name "DefaultAppPool"

# Disable maintenance mode
php artisan up
```

## 📊 Monitoring Deployments

### View Deployment History

```bash
# On GitHub
Go to: Actions tab → Select workflow → View runs

# On Server
cd C:\inetpub\wwwroot\waobiz_web
git log --oneline -10
```

### Check Application Health

```powershell
# Test website response
curl https://waobiz.app

# Check Laravel logs
Get-Content storage\logs\laravel.log -Tail 50

# View IIS logs
Get-Content C:\inetpub\logs\LogFiles\*\*.log -Tail 50
```

## 🛠️ Troubleshooting

### Deployment Fails

1. **Check GitHub Actions logs:**
   - Go to Actions tab
   - Click on failed workflow
   - Review error messages

2. **Check server connectivity:**
   ```powershell
   Test-NetConnection waobiz.app -Port 22  # SSH
   Test-NetConnection waobiz.app -Port 443 # HTTPS
   ```

3. **Verify server permissions:**
   ```powershell
   icacls C:\inetpub\wwwroot\waobiz_web\storage
   icacls C:\inetpub\wwwroot\waobiz_web\bootstrap\cache
   ```

### Application in Maintenance Mode

```powershell
cd C:\inetpub\wwwroot\waobiz_web
php artisan up
```

### Cache Issues

```powershell
cd C:\inetpub\wwwroot\waobiz_web
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Migration Issues

```powershell
# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback --step=1

# Fresh migration (CAUTION: Drops all tables)
php artisan migrate:fresh --force
```

## 📝 Best Practices

1. **Always test in staging first** before deploying to production
2. **Create a backup** before major deployments
3. **Use maintenance mode** during deployments
4. **Monitor logs** after deployment
5. **Keep secrets secure** - never commit them to Git
6. **Document changes** in commit messages
7. **Tag releases** for easy rollback

## 🔒 Security Considerations

- ✅ Never commit `.env` files
- ✅ Use strong passwords for server access
- ✅ Rotate SSH keys regularly
- ✅ Keep GitHub secrets encrypted
- ✅ Use HTTPS for all connections
- ✅ Review deployment logs regularly
- ✅ Limit access to production servers

## 📞 Support

For issues or questions:
- Check GitHub Actions logs
- Review Laravel logs: `storage/logs/laravel.log`
- Check IIS logs
- Contact the development team

## 🔗 Useful Links

- GitHub Repository: https://github.com/Mrwowow/waobiz_web
- Production Site: https://waobiz.app
- GitHub Actions: https://github.com/Mrwowow/waobiz_web/actions
- Laravel Documentation: https://laravel.com/docs

---

**Last Updated:** 2026-01-05
**Version:** 1.0.0
