#!/bin/sh
set -e

# Configure port dynamically from environment ($PORT for Render/Heroku/Cloud Run, default 80)
PORT="${PORT:-80}"
echo "Configuring web server to listen on port ${PORT}..."
sed -i "s/listen [0-9]\+;/listen ${PORT};/g" /etc/nginx/http.d/default.conf /etc/nginx/conf.d/default.conf 2>/dev/null || true
sed -i "s/listen \[::\]:[0-9]\+;/listen [::]:${PORT};/g" /etc/nginx/http.d/default.conf /etc/nginx/conf.d/default.conf 2>/dev/null || true

# Ensure Laravel storage directories exist
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# If sqlite is used and file does not exist, create it
if [ "${DB_CONNECTION}" = "sqlite" ] && [ ! -f "/var/www/html/database/database.sqlite" ]; then
    touch /var/www/html/database/database.sqlite
    chown -R www-data:www-data /var/www/html/database
fi

# Ensure correct permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage link if not exists
php artisan storage:link --force || true

# Clear old caches before running migrations
php artisan config:clear || true

# Run database migrations if requested
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running database migrations..."
    MAX_RETRIES=5
    RETRY_COUNT=0
    until php artisan migrate --force; do
        RETRY_COUNT=$((RETRY_COUNT + 1))
        if [ "$RETRY_COUNT" -ge "$MAX_RETRIES" ]; then
            echo "Database migrations failed after $MAX_RETRIES attempts."
            exit 1
        fi
        echo "Database migration attempt $RETRY_COUNT failed (database may be waking up). Retrying in 3 seconds..."
        sleep 3
    done
fi

# Optimization caches for production
if [ "${APP_ENV}" = "production" ]; then
    echo "Optimizing Laravel configuration and routes..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

exec "$@"
