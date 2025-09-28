@echo off
REM Enterprise Generation Bonus Scheduler
REM Run this as a Windows Scheduled Task for 50,000+ users

echo Starting Enterprise Generation Bonus Processing...
echo Date: %date% Time: %time%

cd /d "C:\xampp\htdocs\nzrobo\db"

REM Step 1: Queue the processing (prepare batches)
echo.
echo [Step 1/2] Preparing enterprise queue...
php enterprise_queue_manager.php queue %1 1000 7

REM Step 2: Process the queue
echo.
echo [Step 2/2] Processing enterprise queue...
php enterprise_queue_manager.php process %1 0 240

REM Step 3: Cleanup old entries (optional)
echo.
echo [Step 3/3] Cleaning up old queue entries...
php enterprise_queue_manager.php cleanup 7

echo.
echo Enterprise generation bonus processing completed!
echo End time: %time%

pause