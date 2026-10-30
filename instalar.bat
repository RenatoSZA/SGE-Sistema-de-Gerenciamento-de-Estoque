@echo off
title Instalador SGE - PC Virgem
echo ======================================================
echo    Iniciando Instalador Automatizado do SGE...
echo ======================================================
echo.

:: Executa o PowerShell ignorando restricoes de politica de execucao e pede elevacao se necessario
powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0setup.ps1"

pause
