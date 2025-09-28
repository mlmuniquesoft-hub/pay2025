#!/bin/bash
# Direct Enterprise Generation Cron Job - Single command processing
# Add to crontab: 0 2 * * * /path/to/direct_generation_cron.sh

LOG_FILE="/var/log/direct_generation.log"
DATE=$(date +%Y-%m-%d)
TIME=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$TIME] Starting Direct Enterprise Generation Processing for $DATE" >> $LOG_FILE

cd /xampp/htdocs/nzrobo/db

# Direct processing with enterprise optimizations
php enterprise_generation_processor.php $DATE --chunk-size=1000 --max-memory=6 --delay=1 --verbose >> $LOG_FILE 2>&1

echo "[$TIME] Direct generation processing completed!" >> $LOG_FILE
echo "----------------------------------------" >> $LOG_FILE