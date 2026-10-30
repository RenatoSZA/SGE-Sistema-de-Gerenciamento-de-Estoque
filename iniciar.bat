@echo off
title SGE - Sistema de Gerenciamento de Estoque
echo ======================================================
echo    Iniciando SGE (Sistema de Gerenciamento de Estoque)
echo ======================================================
echo.

cd /d "%~dp0SGE"

:: Verifica se a pasta vendor existe
if not exist "vendor\" (
    echo [!] Dependencias nao encontradas. Execute primeiro o 'instalar.bat'.
    pause
    exit /b
)

:: Abre o navegador padrao no endereco local
start http://127.0.0.1:8000

:: Inicia o servidor PHP do Laravel
echo Servidor rodando em http://127.0.0.1:8000
echo Pressione CTRL + C para finalizar.
echo.
php artisan serve
