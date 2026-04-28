#!/bin/bash

# Start PHP-FPM
php-fpm -D

# Run migrations (Optional: use --force for production)
# php artisan migrate --force

# Start Nginx
nginx -g "daemon off;"
