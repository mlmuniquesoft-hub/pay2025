#!/bin/bash
# Enhanced Original Generation Cron Job - Uses optimized generation.php
# Add to crontab: 0 2 * * * /path/to/enhanced_generation_cron.sh

LOG_FILE="/var/log/enhanced_generation.log"
DATE=$(date +%Y-%m-%d)
TIME=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$TIME] Starting Enhanced Generation Processing for $DATE" >> $LOG_FILE

cd /xampp/htdocs/nzrobo/db

# Enhanced generation processing
php -r "
require_once 'db.php';
require_once 'functions.php';
require_once 'generation.php';

echo '[' . date('Y-m-d H:i:s') . '] Starting generation bonus processing...' . PHP_EOL;
\$date = '$DATE';
\$result = Generationoncome(\$date);

if(\$result) {
    echo '[' . date('Y-m-d H:i:s') . '] Generation bonus processing completed successfully!' . PHP_EOL;
    exit(0);
} else {
    echo '[' . date('Y-m-d H:i:s') . '] Generation bonus processing failed!' . PHP_EOL;
    exit(1);
}
" >> $LOG_FILE 2>&1

echo "[$TIME] Enhanced generation processing completed!" >> $LOG_FILE
echo "----------------------------------------" >> $LOG_FILE