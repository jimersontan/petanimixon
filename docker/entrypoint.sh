#!/bin/bash

# Fix permissions immediately on startup
mkdir -p /var/www/storage/logs
touch /var/www/storage/logs/laravel.log
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM
php-fpm -D

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link --force

# Start Nginx
nginx -g "daemon off;"
