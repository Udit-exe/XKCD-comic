#!/bin/bash

CRON_JOB_PATH="src/cron.php"
USER="testuser"
CRON_SCHEDULE="0 9 * * *"  # Run at 09:00 AM every day
CRON_COMMAND="php $CRON_JOB_PATH"

# Add the cron job only if it doesn't exist already
(crontab -l | grep -qF "$CRON_COMMAND") || {
    (crontab -l ; echo "$CRON_SCHEDULE $CRON_COMMAND") | crontab -
    echo "Cron job added to run every day at 9 AM."
}

echo "Current cron jobs:"
crontab -l
