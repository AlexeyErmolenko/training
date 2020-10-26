#!/usr/bin/env bash

cd /app/

rm -rf bootstrap/cache/*.php
php composer.phar dump-autoload
php artisan config:clear
php artisan cache:clear

php artisan env


bash tools/wait-for-db.sh training_start-test || exit 1

php artisan migrate
php vendor/bin/phpunit || exit 1
