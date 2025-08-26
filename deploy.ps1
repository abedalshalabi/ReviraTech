<#
.SYNOPSIS
    Laravel to cPanel Deployment Script

.DESCRIPTION
    This PowerShell script automates the deployment of Laravel applications to cPanel hosting.
    It supports multiple deployment methods and environments.

.PARAMETER Method
    Deployment method: 'package', 'ftp', 'sftp', or 'git'

.PARAMETER Environment
    Target environment: 'staging' or 'production'

.PARAMETER FtpHost
    FTP/SFTP server hostname

.PARAMETER FtpUser
    FTP/SFTP username

.PARAMETER FtpPath
    Remote path on the server (e.g., /public_html)

.EXAMPLE
    .\deploy.ps1 -Method package -Environment production
    .\deploy.ps1 -Method ftp -Environment production -FtpHost ftp.yoursite.com -FtpUser username -FtpPath /public_html

.NOTES
    Author: Revira Industrial Team
    Version: 1.0
#>

param(
    [Parameter(Mandatory=$true)]
    [ValidateSet('package', 'ftp', 'sftp', 'git')]
    [string]$Method,
    
    [Parameter(Mandatory=$false)]
    [ValidateSet('staging', 'production')]
    [string]$Environment = 'production',
    
    [Parameter(Mandatory=$false)]
    [string]$FtpHost,
    
    [Parameter(Mandatory=$false)]
    [string]$FtpUser,
    
    [Parameter(Mandatory=$false)]
    [string]$FtpPath = '/public_html'
)

# Configuration
$ProjectName = "revira-industrial"
$DeploymentDir = "deployment-package"
$ExcludeDirs = @('node_modules', '.git', 'storage\logs', 'storage\framework\cache', 'storage\framework\sessions', 'storage\framework\views', 'vendor', '.vscode', '.idea', 'deployment-package', 'tests')
$ExcludeFiles = @('.env', '.env.*', '*.log', 'deploy.bat', 'deploy.ps1', 'sync.bat', 'sync.ps1', '*.md')

function Write-Header {
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "Laravel cPanel Deployment Script" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "Method: $Method" -ForegroundColor Yellow
    Write-Host "Environment: $Environment" -ForegroundColor Yellow
    Write-Host "Time: $(Get-Date)" -ForegroundColor Yellow
    Write-Host "========================================" -ForegroundColor Cyan
}

function Test-Prerequisites {
    Write-Host "[0/6] Checking prerequisites..." -ForegroundColor Green
    
    # Check if .env file exists for the environment
    if (-not (Test-Path ".env.$Environment")) {
        Write-Error "Error: .env.$Environment file not found!"
        Write-Host "Please create environment-specific configuration file." -ForegroundColor Red
        exit 1
    }
    
    # Check if composer is available
    try {
        $null = Get-Command composer -ErrorAction Stop
    } catch {
        Write-Error "Composer not found! Please install Composer first."
        exit 1
    }
    
    # Check if php is available
    try {
        $null = Get-Command php -ErrorAction Stop
    } catch {
        Write-Error "PHP not found! Please install PHP first."
        exit 1
    }
    
    Write-Host "Prerequisites check passed!" -ForegroundColor Green
}

function New-DeploymentPackage {
    Write-Host "[1/6] Preparing deployment package..." -ForegroundColor Green
    
    # Remove existing deployment directory
    if (Test-Path $DeploymentDir) {
        Remove-Item $DeploymentDir -Recurse -Force
    }
    
    # Create deployment directory
    New-Item -ItemType Directory -Path $DeploymentDir -Force | Out-Null
    
    # Copy files excluding development files
    $RobocopyArgs = @(
        '.',
        $DeploymentDir,
        '/E',
        '/XD', ($ExcludeDirs -join ' '),
        '/XF', ($ExcludeFiles -join ' '),
        '/NFL', '/NDL', '/NJH', '/NJS', '/NC', '/NS'
    )
    
    & robocopy @RobocopyArgs | Out-Null
    
    # Copy environment-specific .env file
    Copy-Item ".env.$Environment" "$DeploymentDir\.env"
    
    Write-Host "Deployment package prepared successfully!" -ForegroundColor Green
}

function Install-Dependencies {
    Write-Host "[2/6] Installing production dependencies..." -ForegroundColor Green
    
    Push-Location $DeploymentDir
    
    try {
        # Install composer dependencies
        & composer install --optimize-autoloader --no-dev --no-interaction
        if ($LASTEXITCODE -ne 0) {
            throw "Composer install failed!"
        }
        
        Write-Host "Dependencies installed successfully!" -ForegroundColor Green
    } catch {
        Write-Error "Error installing dependencies: $_"
        Pop-Location
        exit 1
    } finally {
        Pop-Location
    }
}

function Optimize-Laravel {
    Write-Host "[3/6] Optimizing Laravel for production..." -ForegroundColor Green
    
    Push-Location $DeploymentDir
    
    try {
        # Clear and cache configuration
        & php artisan config:clear
        & php artisan config:cache
        
        # Cache routes
        & php artisan route:clear
        & php artisan route:cache
        
        # Cache views
        & php artisan view:clear
        & php artisan view:cache
        
        Write-Host "Laravel optimization completed!" -ForegroundColor Green
    } catch {
        Write-Error "Error optimizing Laravel: $_"
        Pop-Location
        exit 1
    } finally {
        Pop-Location
    }
}

function Build-Assets {
    Write-Host "[4/6] Building assets..." -ForegroundColor Green
    
    Push-Location $DeploymentDir
    
    try {
        if (Test-Path "package.json") {
            # Install npm dependencies
            & npm ci --production --silent
            
            # Build assets
            & npm run build
            
            Write-Host "Assets built successfully!" -ForegroundColor Green
        } else {
            Write-Host "No package.json found, skipping asset build." -ForegroundColor Yellow
        }
    } catch {
        Write-Warning "Error building assets: $_"
    } finally {
        Pop-Location
    }
}

function New-Archive {
    Write-Host "[5/6] Creating deployment archive..." -ForegroundColor Green
    
    $Timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
    $ArchiveName = "$ProjectName-$Environment-$Timestamp.zip"
    
    try {
        Compress-Archive -Path "$DeploymentDir\*" -DestinationPath $ArchiveName -Force
        Write-Host "Archive created: $ArchiveName" -ForegroundColor Green
        return $ArchiveName
    } catch {
        Write-Error "Error creating archive: $_"
        exit 1
    }
}

function Deploy-Package {
    $ArchiveName = New-Archive
    
    Write-Host "[6/6] Deployment package ready!" -ForegroundColor Green
    
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "DEPLOYMENT INSTRUCTIONS" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "`n1. Upload $ArchiveName to your cPanel File Manager" -ForegroundColor White
    Write-Host "2. Extract the archive in your domain's public_html folder" -ForegroundColor White
    Write-Host "3. Run the following commands in cPanel Terminal:" -ForegroundColor White
    Write-Host "`n   cd public_html" -ForegroundColor Yellow
    Write-Host "   php artisan migrate --force" -ForegroundColor Yellow
    Write-Host "   php artisan storage:link" -ForegroundColor Yellow
    Write-Host "   chmod -R 755 storage bootstrap/cache" -ForegroundColor Yellow
    Write-Host "   chown -R username:username storage bootstrap/cache" -ForegroundColor Yellow
    Write-Host "`n4. Update your cPanel database settings if needed" -ForegroundColor White
    Write-Host "5. Set up cron jobs for Laravel scheduler (optional):" -ForegroundColor White
    Write-Host "   * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1" -ForegroundColor Yellow
    Write-Host "`n========================================" -ForegroundColor Cyan
}

function Deploy-FTP {
    if (-not $FtpHost -or -not $FtpUser) {
        Write-Error "FTP deployment requires -FtpHost and -FtpUser parameters"
        exit 1
    }
    
    Write-Host "[6/6] Deploying via FTP..." -ForegroundColor Green
    Write-Host "FTP deployment requires manual setup or additional tools like WinSCP." -ForegroundColor Yellow
    Write-Host "Please use the generated package and upload manually." -ForegroundColor Yellow
    
    Deploy-Package
}

function Show-PostDeployment {
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "POST-DEPLOYMENT CHECKLIST" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "□ Database migrations completed" -ForegroundColor White
    Write-Host "□ Storage link created" -ForegroundColor White
    Write-Host "□ File permissions set correctly" -ForegroundColor White
    Write-Host "□ Environment variables configured" -ForegroundColor White
    Write-Host "□ SSL certificate installed" -ForegroundColor White
    Write-Host "□ Cron jobs configured" -ForegroundColor White
    Write-Host "□ Website tested and working" -ForegroundColor White
    Write-Host "`n========================================" -ForegroundColor Cyan
}

function Cleanup {
    Write-Host "Cleaning up temporary files..." -ForegroundColor Green
    
    if (Test-Path $DeploymentDir) {
        Remove-Item $DeploymentDir -Recurse -Force
    }
}

# Main execution
try {
    Write-Header
    Test-Prerequisites
    New-DeploymentPackage
    Install-Dependencies
    Optimize-Laravel
    Build-Assets
    
    switch ($Method) {
        'package' { Deploy-Package }
        'ftp' { Deploy-FTP }
        'sftp' { Deploy-FTP }
        'git' { 
            Write-Host "Git deployment method not implemented yet." -ForegroundColor Yellow
            Deploy-Package
        }
    }
    
    Show-PostDeployment
    
} catch {
    Write-Error "Deployment failed: $_"
    exit 1
} finally {
    Cleanup
}

Write-Host "`nDeployment script completed successfully!" -ForegroundColor Green