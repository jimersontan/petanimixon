#!/bin/bash

# Start PHP-FPM
php-fpm -D

# Fix permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Run migrations
php artisan migrate --force

# Start Nginx
nginx -g "daemon off;"
