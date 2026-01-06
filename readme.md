# WaoBiz - Smart Business Manager

[![CI/CD Pipeline](https://github.com/Mrwowow/waobiz_web/actions/workflows/ci.yml/badge.svg)](https://github.com/Mrwowow/waobiz_web/actions)
[![Deployment](https://github.com/Mrwowow/waobiz_web/actions/workflows/deploy.yml/badge.svg)](https://github.com/Mrwowow/waobiz_web/actions)

A comprehensive Laravel-based business management system with automated CI/CD pipeline.

## 🚀 Features

- **Point of Sale (POS)** - Complete POS system
- **Inventory Management** - Track stock and inventory
- **Sales & Purchases** - Manage transactions
- **Customer Management** - CRM functionality
- **Reports & Analytics** - Business insights
- **Multi-user Support** - Role-based access control
- **Payment Integrations** - Multiple payment gateways

## 🛠️ Technology Stack

- **Framework:** Laravel 9.x
- **PHP:** 8.3+
- **Database:** MySQL
- **Frontend:** Blade Templates, Bootstrap
- **Server:** Windows Server / IIS
- **CI/CD:** GitHub Actions

## 🚢 Deployment

### Automatic Deployment

Push to `main` branch to trigger automatic deployment:

```bash
git add .
git commit -m "Your changes"
git push origin main
```

### Manual Deployment

Run the deployment script on the server:

```powershell
cd C:\inetpub\wwwroot\waobiz_web
powershell -ExecutionPolicy Bypass -File scripts\deploy.ps1
```

### Rollback

If something goes wrong:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\rollback.ps1
```

## 📚 Documentation

- **[CI/CD Setup Guide](CI-CD-SETUP.md)** - Complete CI/CD documentation
- **[GitHub Secrets Setup](https://github.com/Mrwowow/waobiz_web/settings/secrets/actions)** - Configure deployment secrets
- **[Actions Dashboard](https://github.com/Mrwowow/waobiz_web/actions)** - View deployment status

## 🔐 Security

- SSL/TLS encryption via Cloudflare
- Environment-based configuration
- Secure secret management via GitHub Secrets
- Regular automated backups
- Role-based access control

## 🌐 Links

- **Production:** https://waobiz.app
- **Repository:** https://github.com/Mrwowow/waobiz_web
- **Issues:** https://github.com/Mrwowow/waobiz_web/issues

---

Based on Ultimate POS by [Ultimate Fosters](http://ultimatefosters.com)

**Version:** 1.0.0 | **Last Updated:** 2026-01-05
