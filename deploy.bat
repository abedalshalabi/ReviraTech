@echo off
REM ========================================
REM Laravel to cPanel Deployment Script
REM ========================================
REM This script helps sync your local Laravel project to cPanel
REM
REM Usage:
REM   deploy.bat [method] [environment]
REM
REM Methods: ftp, sftp, rsync
REM Environments: staging, production
REM
REM Examples:
REM   deploy.bat ftp production
REM   deploy.bat sftp staging
REM ========================================

setlocal enabledelayedexpansion

REM Default values
set METHOD=%1
set ENVIRONMENT=%2

if "%METHOD%"=="" (
    echo Please specify deployment method: ftp, sftp, or rsync
    echo Usage: deploy.bat [method] [environment]
    exit /b 1
)

if "%ENVIRONMENT%"=="" (
    set ENVIRONMENT=production
)

echo ========================================
echo Laravel cPanel Deployment Script
echo ========================================
echo Method: %METHOD%
echo Environment: %ENVIRONMENT%
echo Time: %date% %time%
echo ========================================

REM Check if .env file exists for the environment
if not exist ".env.%ENVIRONMENT%" (
    echo Error: .env.%ENVIRONMENT% file not found!
    echo Please create environment-specific configuration file.
    exit /b 1
)

REM Create deployment package directory
if not exist "deployment-package" mkdir deployment-package

echo [1/6] Preparing deployment package...

REM Copy files to deployment package (excluding development files)
robocopy . deployment-package /E /XD node_modules .git storage\logs storage\framework\cache storage\framework\sessions storage\framework\views vendor .vscode .idea deployment-package /XF .env .env.* *.log deploy.bat deploy.sh sync.bat sync.sh

REM Copy environment-specific .env file
copy ".env.%ENVIRONMENT%" "deployment-package\.env"

echo [2/6] Installing production dependencies...
cd deployment-package
composer install --optimize-autoloader --no-dev --no-interaction
if errorlevel 1 (
    echo Error: Composer install failed!
    cd ..
    exit /b 1
)

echo [3/6] Optimizing Laravel for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo [4/6] Building assets...
if exist "package.json" (
    npm ci --production
    npm run build
)

cd ..

echo [5/6] Creating deployment archive...
set TIMESTAMP=%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%
set TIMESTAMP=%TIMESTAMP: =0%
set ARCHIVE_NAME=revira-industrial-%ENVIRONMENT%-%TIMESTAMP%.zip

REM Create zip archive (requires PowerShell)
powershell -command "Compress-Archive -Path 'deployment-package\*' -DestinationPath '%ARCHIVE_NAME%' -Force"

echo [6/6] Deployment package created: %ARCHIVE_NAME%
echo.
echo ========================================
echo DEPLOYMENT INSTRUCTIONS
echo ========================================
echo.
echo 1. Upload %ARCHIVE_NAME% to your cPanel File Manager
echo 2. Extract the archive in your domain's public_html folder
echo 3. Run the following commands in cPanel Terminal:
echo.
echo    cd public_html
echo    php artisan migrate --force
echo    php artisan storage:link
echo    chmod -R 755 storage bootstrap/cache
echo    chown -R username:username storage bootstrap/cache
echo.
echo 4. Update your cPanel database settings if needed
echo 5. Set up cron jobs for Laravel scheduler (optional):
echo    * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
echo.
echo ========================================
echo MANUAL SYNC METHODS
echo ========================================
echo.
echo FTP Upload:
echo - Use FileZilla or WinSCP
echo - Upload deployment-package contents to public_html
echo - Exclude: .env, storage/logs, storage/framework/cache
echo.
echo SFTP/SSH:
echo - Use WinSCP or PuTTY
echo - rsync -avz --exclude-from='.gitignore' . user@server:/path/to/public_html/
echo.
echo Git Deployment (if cPanel supports Git):
echo - git clone your-repository.git
echo - git pull origin main
echo - composer install --no-dev
echo - php artisan migrate --force
echo.
echo ========================================

REM Cleanup
echo Cleaning up temporary files...
rmdir /s /q deployment-package

echo.
echo Deployment package ready: %ARCHIVE_NAME%
echo Upload this file to your cPanel and extract it.
echo.
pause