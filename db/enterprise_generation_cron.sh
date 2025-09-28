#!/bin/bash
# Enterprise Generation Cron Job - Queue-based processing for 50K+ users
# Add to crontab: 0 2 * * * /path/to/enterprise_generation_cron.sh

LOG_FILE="/var/log/enterprise_generation.log"
DATE=$(date +%Y-%m-%d)
TIME=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$TIME] Starting Enterprise Generation Queue Processing for $DATE" >> $LOG_FILE

cd /xampp/htdocs/nzrobo/db

# Step 1: Queue the processing (prepare batches)
echo "[$TIME] Step 1: Preparing enterprise queue..." >> $LOG_FILE
php enterprise_queue_manager.php queue $DATE 1000 7 >> $LOG_FILE 2>&1

# Step 2: Process the queue
echo "[$TIME] Step 2: Processing enterprise queue..." >> $LOG_FILE
php enterprise_queue_manager.php process $DATE 0 240 >> $LOG_FILE 2>&1

# Step 3: Cleanup old entries (weekly cleanup)
if [ $(date +%u) -eq 1 ]; then
    echo "[$TIME] Step 3: Weekly cleanup of old queue entries..." >> $LOG_FILE
    php enterprise_queue_manager.php cleanup 7 >> $LOG_FILE 2>&1
fi

echo "[$TIME] Enterprise generation processing completed!" >> $LOG_FILE
echo "----------------------------------------" >> $LOG_FILE