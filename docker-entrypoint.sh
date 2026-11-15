#!/bin/sh
set -e
cd /var/www/html

# First start: create the SQLite file, tables and sample data
if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
  php artisan migrate --force
  php artisan db:seed --force
else
  php artisan migrate --force
fi

php artisan config:cache || true
exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
