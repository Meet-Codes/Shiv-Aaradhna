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

# Run database migrations if requested
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || true
fi

# Optimization caches for production
if [ "${APP_ENV}" = "production" ]; then
    echo "Optimizing Laravel configuration and routes..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

exec "$@"
