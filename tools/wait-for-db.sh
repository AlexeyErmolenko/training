#!/usr/bin/env bash

TRY_COUNT=0
TIMEOUT_SECONDS=15
DATABASE=${1:-training_start}
echo -e "Waiting for database '${DATABASE}'..."

until (php /app/tools/check_db_status.php db user secret ${DATABASE}); do
    if [[ $(( TRY_COUNT++ )) -eq $TIMEOUT_SECONDS ]]; then
        echo -e "\033[0;31m !!! '${DATABASE}' DB is not available after $TIMEOUT_SECONDS seconds \033[0m"
        exit 1
    fi
    sleep 1
done
echo -e "Database '${DATABASE}' is up"
