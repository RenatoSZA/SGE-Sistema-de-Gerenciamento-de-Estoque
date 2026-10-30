<#
.SYNOPSIS
    Script de automação para configuração e execução do SGE em PC Windows virgem.
.DESCRIPTION
    Instala dependências necessárias (Git, PHP, Composer, Node.js, MySQL) via Winget,
    configura o ambiente, instala dependências do Laravel e do Vite,
    executa as migrações/seeders e inicia a aplicação.
#>

param (
    [switch]$SkipInstall
)

# Garantir privilégios de Administrador
$isAdmin = ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
if (-not $isAdmin) {
    Write-Host "[!] Solicitando permissao de Administrador para instalar pacotes..." -ForegroundColor Yellow
    Start-Process powershell.exe -ArgumentList ("-NoProfile -ExecutionPolicy Bypass -File `"$PSCommandPath`"") -Verb RunAs
    exit
}

$Host.UI.RawUI.WindowTitle = "Instalador Automatizado SGE"
Clear-Host

Write-Host "======================================================" -ForegroundColor Cyan
Write-Host "      SGE - INSTALADOR AUTOMATIZADO (PC VIRGEM)       " -ForegroundColor Cyan
Write-Host "======================================================" -ForegroundColor Cyan
Write-Host ""

# Função para atualizar o PATH na sessão atual
function Refresh-EnvironmentPath {
    $env:Path = [System.Environment]::GetEnvironmentVariable("Path", "Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path", "User")
}

# 1. Instalar dependências via Winget se necessário
if (-not $SkipInstall) {
    Write-Host "[1/5] Verificando dependencias do sistema..." -ForegroundColor Green

    $packages = @(
        @{ Name = "Git"; Command = "git"; Id = "Git.Git" },
        @{ Name = "Node.js"; Command = "node"; Id = "OpenJS.NodeJS.LTS" },
        @{ Name = "PHP 8.3"; Command = "php"; Id = "PHP.PHP.8.3" },
        @{ Name = "Composer"; Command = "composer"; Id = "Composer.Composer" }
    )

    foreach ($pkg in $packages) {
        if (-not (Get-Command $pkg.Command -ErrorAction SilentlyContinue)) {
            Write-Host " -> Instalando $($pkg.Name)..." -ForegroundColor Yellow
            winget install --id $pkg.Id -e --silent --accept-package-agreements --accept-source-agreements
            Refresh-EnvironmentPath
        } else {
            Write-Host " -> $($pkg.Name) ja esta instalado." -ForegroundColor Gray
        }
    }

    # Ativar extensões no php.ini se o PHP foi instalado avulso
    $phpPath = (Get-Command php -ErrorAction SilentlyContinue).Source
    if ($phpPath) {
        $phpDir = Split-Path $phpPath
        $iniPath = Join-Path $phpDir "php.ini"
        $iniDevPath = Join-Path $phpDir "php.ini-development"
        $iniProdPath = Join-Path $phpDir "php.ini-production"

        if (-not (Test-Path $iniPath)) {
            if (Test-Path $iniDevPath) {
                Copy-Item $iniDevPath $iniPath
            } elseif (Test-Path $iniProdPath) {
                Copy-Item $iniProdPath $iniPath
            }
        }

        if (Test-Path $iniPath) {
            Write-Host " -> Configurando extensoes necessarias no php.ini..." -ForegroundColor Gray
            $iniContent = Get-Content $iniPath
            $extensionsToEnable = @("curl", "fileinfo", "mbstring", "openssl", "pdo_mysql", "pdo_sqlite", "sqlite3", "zip")
            foreach ($ext in $extensionsToEnable) {
                $iniContent = $iniContent -replace ";\s*extension\s*=\s*$ext", "extension=$ext"
            }
            # Garantir que extension_dir seja ativado
            $iniContent = $iniContent -replace ";\s*extension_dir\s*=\s*`"ext`"", "extension_dir = `"ext`""
            Set-Content -Path $iniPath -Value $iniContent
        }
    }
}

Refresh-EnvironmentPath

# 2. Localizar a pasta do projeto Laravel
$projectRoot = $PSScriptRoot
$laravelDir = Join-Path $projectRoot "SGE"
if (-not (Test-Path (Join-Path $laravelDir "artisan"))) {
    # Se já estiver dentro de SGE/
    if (Test-Path (Join-Path $projectRoot "artisan")) {
        $laravelDir = $projectRoot
    } else {
        Write-Host "[X] Erro: Pasta do Laravel (artisan) nao encontrada!" -ForegroundColor Red
        Pause
        exit 1
    }
}

Set-Location $laravelDir

# 3. Configurar arquivo .env
Write-Host ""
Write-Host "[2/5] Configurando variaveis de ambiente (.env)..." -ForegroundColor Green
$envFile = Join-Path $laravelDir ".env"
$envExample = Join-Path $laravelDir ".env.example"

if (-not (Test-Path $envFile)) {
    if (Test-Path $envExample) {
        Copy-Item $envExample $envFile
        Write-Host " -> .env criado a partir de .env.example" -ForegroundColor Yellow
    }
}

# 4. Instalar dependências Composer e NPM
Write-Host ""
Write-Host "[3/5] Instalando dependencias do projeto (Composer e NPM)..." -ForegroundColor Green

if (Test-Path (Join-Path $laravelDir "composer.json")) {
    Write-Host " -> Executando composer install..." -ForegroundColor Yellow
    composer install --no-interaction --prefer-dist
}

if (Test-Path (Join-Path $laravelDir "package.json")) {
    Write-Host " -> Executando npm install..." -ForegroundColor Yellow
    npm install --silent
    Write-Host " -> Compilando assets com Vite..." -ForegroundColor Yellow
    npm run build
}

# 5. Configurar Laravel e Banco de Dados
Write-Host ""
Write-Host "[4/5] Configurando aplicacao e banco de dados..." -ForegroundColor Green

# Gerar APP_KEY se necessário
php artisan key:generate --force

# Verificar conexão com Banco de Dados
Write-Host " -> Testando conexao com o banco de dados..." -ForegroundColor Yellow
$migrationSuccess = $false

try {
    php artisan migrate --force
    $migrationSuccess = $true
} catch {
    $migrationSuccess = $false
}

# Se MySQL falhar (ex: MySQL nao instalado ou servico desligado), perguntar/oferecer SQLite como fallback
if (-not $migrationSuccess) {
    Write-Host "[!] Conexao MySQL nao respondeu ou banco nao encontrado." -ForegroundColor Yellow
    Write-Host "    Alternando para SQLite (auto-configuravel, sem necessidade de servidor MySQL)..." -ForegroundColor Cyan
    
    $sqlitePath = Join-Path $laravelDir "database\database.sqlite"
    if (-not (Test-Path $sqlitePath)) {
        New-Item -ItemType File -Path $sqlitePath -Force | Out-Null
    }

    # Atualizar .env para SQLite
    $envContent = Get-Content $envFile
    $envContent = $envContent -replace "DB_CONNECTION=.*", "DB_CONNECTION=sqlite"
    $envContent = $envContent -replace "DB_HOST=.*", "# DB_HOST=127.0.0.1"
    $envContent = $envContent -replace "DB_PORT=.*", "# DB_PORT=3306"
    $envContent = $envContent -replace "DB_DATABASE=.*", "DB_DATABASE=$sqlitePath"
    $envContent = $envContent -replace "DB_USERNAME=.*", "# DB_USERNAME=root"
    $envContent = $envContent -replace "DB_PASSWORD=.*", "# DB_PASSWORD="
    Set-Content -Path $envFile -Value $envContent

    php artisan config:clear
    php artisan migrate --force
}

# Executar Seeders
Write-Host " -> Populando dados iniciais (DashboardSeeder)..." -ForegroundColor Yellow
php artisan db:seed --class=DashboardSeeder --force

# 6. Criar Atalho de Inicialização Rápida no desktop e na pasta
Write-Host ""
Write-Host "[5/5] Finalizando instalacao e iniciando sistema..." -ForegroundColor Green

# Iniciar servidor e abrir navegador
Write-Host ""
Write-Host "======================================================" -ForegroundColor Cyan
Write-Host "  SISTEMA PRONTO! Abrindo http://127.0.0.1:8000 ...   " -ForegroundColor Green
Write-Host "  Para encerrar o servidor, pressione CTRL + C.       " -ForegroundColor Yellow
Write-Host "======================================================" -ForegroundColor Cyan
Write-Host ""

Start-Process "http://127.0.0.1:8000"
php artisan serve
