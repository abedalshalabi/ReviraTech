# Deployment and Synchronization Guide

This guide explains how to synchronize code between your local development environment and cPanel hosting.

## Overview

The project includes automated deployment scripts and environment-specific configurations to streamline the synchronization process between local development and production environments.

## Files Structure

```
├── deploy.bat              # Windows batch deployment script
├── deploy.ps1              # PowerShell deployment script (recommended)
├── .env                     # Local development environment
├── .env.production          # Production environment template
├── .env.staging             # Staging environment template
├── deployment-package/      # Generated deployment files
└── DEPLOYMENT.md           # This documentation
```

## Quick Start

### 1. Initial Setup

1. **Configure Environment Files**:
   - Copy `.env.production` to your cPanel and rename it to `.env`
   - Update database credentials, domain, and email settings
   - Set `APP_DEBUG=false` for production

2. **Set Up Git Repository** (if not already done):
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   ```

### 2. Deployment Methods

#### Method 1: Automated Deployment (Recommended)

Use the PowerShell script for automated deployment:

```powershell
# Package files for deployment
.\deploy.ps1 package

# Deploy via FTP
.\deploy.ps1 ftp

# Deploy via SFTP
.\deploy.ps1 sftp

# Deploy via Git (if cPanel supports it)
.\deploy.ps1 git
```

#### Method 2: Manual Deployment

1. **Prepare Deployment Package**:
   ```powershell
   .\deploy.ps1 package
   ```

2. **Upload to cPanel**:
   - Extract `deployment-package/revira-industrial-production.zip` to your cPanel public_html
   - Or use cPanel File Manager to upload and extract

3. **Configure on cPanel**:
   - Update `.env` file with production settings
   - Run Laravel optimization commands via cPanel Terminal

## Environment Configuration

### Local Development (.env)
- `APP_ENV=local`
- `APP_DEBUG=true`
- Local database settings
- Development mail settings

### Staging (.env.staging)
- `APP_ENV=staging`
- `APP_DEBUG=true`
- Staging database settings
- Test mail settings (Mailtrap)

### Production (.env.production)
- `APP_ENV=production`
- `APP_DEBUG=false`
- Production database settings
- Production mail settings
- Security optimizations

## Deployment Script Features

### Package Creation
- Excludes development files (.git, node_modules, tests)
- Installs production dependencies
- Builds optimized assets
- Caches Laravel configurations
- Creates deployment-ready ZIP file

### FTP/SFTP Deployment
- Automated file transfer
- Backup existing files
- Upload new files
- Run post-deployment commands

### Git Deployment
- Push to remote repository
- Pull on production server
- Run deployment commands

## cPanel Specific Instructions

### 1. Database Setup
1. Create MySQL database in cPanel
2. Create database user and assign privileges
3. Update `.env` file with database credentials

### 2. File Permissions
Set proper permissions for Laravel directories:
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
```

### 3. Symbolic Links
Create storage link for file uploads:
```bash
php artisan storage:link
```

### 4. Laravel Optimization
Run these commands after deployment:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## Synchronization Workflow

### Development to Production
1. **Develop locally** with `.env` (local settings)
2. **Test changes** thoroughly
3. **Commit to Git**:
   ```bash
   git add .
   git commit -m "Feature: description"
   ```
4. **Deploy using script**:
   ```powershell
   .\deploy.ps1 package
   .\deploy.ps1 ftp  # or sftp/git
   ```
5. **Verify deployment** on production

### Production to Local (Reverse Sync)
1. **Backup production database**
2. **Download database** to local
3. **Pull any manual changes** made on production
4. **Update local environment**

## Best Practices

### Security
- Never commit `.env` files to Git
- Use strong passwords for production
- Enable HTTPS on production
- Set `APP_DEBUG=false` in production
- Use secure session cookies

### Performance
- Enable Laravel caching in production
- Optimize Composer autoloader
- Use CDN for static assets
- Enable gzip compression

### Maintenance
- Regular database backups
- Monitor error logs
- Keep Laravel and dependencies updated
- Test deployments on staging first

## Troubleshooting

### Common Issues

1. **Permission Errors**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

2. **Database Connection**:
   - Verify database credentials in `.env`
   - Check database server status
   - Ensure database user has proper privileges

3. **File Upload Issues**:
   ```bash
   php artisan storage:link
   chmod -R 775 storage/app/public
   ```

4. **Cache Issues**:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

### Log Files
- Local: `storage/logs/laravel.log`
- Production: Check cPanel error logs
- Web server: Check Apache/Nginx logs

## Support

For deployment issues:
1. Check Laravel logs
2. Verify environment configuration
3. Test database connectivity
4. Review file permissions
5. Contact hosting support if needed

## Version Control

### Git Workflow
```bash
# Daily workflow
git pull origin main
# Make changes
git add .
git commit -m "Description of changes"
git push origin main

# Deploy to production
.\deploy.ps1 package
.\deploy.ps1 ftp
```

### Branching Strategy
- `main`: Production-ready code
- `develop`: Development branch
- `feature/*`: Feature branches
- `hotfix/*`: Emergency fixes

## Monitoring

### Health Checks
- Application uptime
- Database connectivity
- File upload functionality
- Email delivery
- Error rates

### Performance Monitoring
- Page load times
- Database query performance
- Memory usage
- Disk space

This documentation should be updated as the deployment process evolves.