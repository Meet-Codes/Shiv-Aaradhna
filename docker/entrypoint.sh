#!/bin/sh
set -e

# Step 1: Configure Nginx Render port ($PORT for Render, default 80)
PORT="${PORT:-80}"
echo "Configuring web server to listen on port ${PORT}..."
sed -i "s/listen [0-9]\+;/listen ${PORT};/g" /etc/nginx/http.d/default.conf /etc/nginx/conf.d/default.conf 2>/dev/null || true
sed -i "s/listen \[::\]:[0-9]\+;/listen [::]:${PORT};/g" /etc/nginx/http.d/default.conf /etc/nginx/conf.d/default.conf 2>/dev/null || true

# Step 2: Prepare Laravel storage and cache directories
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Harmless storage link
php artisan storage:link --force || true

# Clear any stale bootstrap configuration caches
php artisan config:clear || true

# Step 3: Mandatory Runtime Verification of PHP PostgreSQL Driver
echo "=== PHP DATABASE DRIVER CHECK ==="
PHP_VER=$(php -r 'echo PHP_VERSION;')
echo "PHP: ${PHP_VER}"

if php -r 'exit(extension_loaded("pdo_pgsql") && in_array("pgsql", PDO::getAvailableDrivers(), true) ? 0 : 1);'; then
    echo "pdo_pgsql loaded: YES"
else
    echo "FATAL: pdo_pgsql driver is NOT loaded in PHP runtime!"
    echo "Available PDO drivers: $(php -r 'echo implode(", ", PDO::getAvailableDrivers());')"
    echo "Aborting container startup. Web server will not start."
    exit 1
fi
echo "PDO drivers: $(php -r 'echo implode(", ", PDO::getAvailableDrivers());')"
echo "================================="

# Step 4: Verify Laravel DB configuration without printing secrets
echo "=== DATABASE CONFIG ==="
echo "DB_CONNECTION=${DB_CONNECTION:-NOT_SET}"
php artisan config:show database.default
php artisan config:show database.connections.pgsql.driver
echo "======================="

# Step 5 & 6: Run database migrations if requested; stop immediately on failure
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running database migrations..."
    # Neon compute wake-up retry loop (up to 5 attempts, 3s delay)
    MAX_RETRIES=5
    RETRY_COUNT=0
    MIGRATE_SUCCESS=false

    until [ "$RETRY_COUNT" -ge "$MAX_RETRIES" ]; do
        if php artisan migrate --force; then
            MIGRATE_SUCCESS=true
            break
        fi
        RETRY_COUNT=$((RETRY_COUNT + 1))
        if [ "$RETRY_COUNT" -lt "$MAX_RETRIES" ]; then
            echo "Database migration attempt $RETRY_COUNT failed (database may be waking up). Retrying in 3 seconds..."
            sleep 3
        fi
    done

    if [ "$MIGRATE_SUCCESS" != "true" ]; then
        echo "FATAL: Database migrations failed after $MAX_RETRIES attempts. Aborting container startup."
        exit 1
    fi
    echo "Database migrations completed successfully."
fi

# Step 7, 8, 9: Cache Laravel configuration, routes, and views (explicitly without ignoring errors)
if [ "${APP_ENV}" = "production" ]; then
    echo "Optimizing Laravel configuration and routes..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Step 10 & 11: Supervisor starts PHP-FPM + Nginx
exec "$@"
