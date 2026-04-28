#!/bin/bash

# Start PHP-FPM
php-fpm -D

# Run migrations
php artisan migrate --force

# Start Nginx
nginx -g "daemon off;"
