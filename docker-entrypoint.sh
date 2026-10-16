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

# Ensure database exists before running migrations
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ]; then
    echo "Checking and preparing database: ${DB_DATABASE}..."
    php -r '
        $host = getenv("DB_HOST");
        $port = getenv("DB_PORT") ?: 4000;
        $user = getenv("DB_USERNAME");
        $pass = getenv("DB_PASSWORD");
        $db = getenv("DB_DATABASE");
        if ($host && $db) {
            try {
                $opts = [];
                if (file_exists("/etc/ssl/certs/ca-certificates.crt")) {
                    $opts[PDO::MYSQL_ATTR_SSL_CA] = "/etc/ssl/certs/ca-certificates.crt";
                }
                $pdo = new PDO("mysql:host={$host};port={$port}", $user, $pass, $opts);
                $pdo->exec("CREATE DATABASE IF NOT EXISTS \`{$db}\`;");
                echo "Database \`{$db}\` verified/created successfully.\n";
            } catch (Exception $e) {
                echo "Notice: " . $e->getMessage() . "\n";
            }
        }
    ' || true

    echo "Running database migrations..."
    php artisan migrate --force || echo "Warning: Database migration failed. Please verify DB credentials in Render dashboard."

    echo "Running database seeder..."
    php artisan db:seed --force || echo "Notice: Database seeder skipped or already seeded."
fi

# Optimize Laravel cache
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache web server on port ${PORT}..."
exec apache2-foreground
