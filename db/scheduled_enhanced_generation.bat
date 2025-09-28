@echo off
REM Enhanced Original Generation Processing
REM Uses optimized generation.php with enterprise improvements

echo Starting Enhanced Generation Processing...
echo Date: %date% Time: %time%

cd /d "C:\xampp\htdocs\nzrobo\db"

REM Call the enhanced generation function
echo.
echo Processing generation bonuses using enhanced core...
php -r "
require_once 'db.php';
require_once 'functions.php';
require_once 'generation.php';

echo 'Starting generation bonus processing...' . PHP_EOL;
\$date = isset(\$argv[1]) ? \$argv[1] : date('Y-m-d');
\$result = Generationoncome(\$date);

if(\$result) {
    echo 'Generation bonus processing completed successfully!' . PHP_EOL;
} else {
    echo 'Generation bonus processing failed!' . PHP_EOL;
}
" %1

echo.
echo Enhanced generation processing completed!
echo End time: %time%

pause