@echo off
echo Starting Laravel Server (Bypassing broken Herd loader)...
php -d auto_prepend_file= -S 127.0.0.1:8000 -t public
pause
