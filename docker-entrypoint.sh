#!/bin/bash
set -e

# Configure Apache port based on Render dynamic $PORT
PORT="${PORT:-10000}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run database migrations if external DB is configured
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Warning: Database migration failed. Please verify DB credentials in Render dashboard."
fi

# Optimize Laravel cache
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache web server on port ${PORT}..."
exec apache2-foreground
