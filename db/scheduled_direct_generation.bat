@echo off
REM Direct Enterprise Generation Processing
REM For 50K+ users with single command execution

echo Starting Direct Enterprise Generation Processing...
echo Date: %date% Time: %time%

cd /d "C:\xampp\htdocs\nzrobo\db"

REM Direct processing with enterprise optimizations
echo.
echo Processing generation bonuses for all users...
php enterprise_generation_processor.php %1 --chunk-size=1000 --max-memory=6 --delay=1 --verbose

echo.
echo Direct generation bonus processing completed!
echo End time: %time%

pause