@echo off
:: Ganti direktori ke folder proyek
cd /d C:\laragon\www\ymi\websocket

:: Jalankan Cmder dan eksekusi perintah
start C:\laragon\bin\cmder\cmder.exe /START %CD% /SINGLE /C "php server.php"