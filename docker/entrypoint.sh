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

# Step 3: Normalize Neon PostgreSQL pooled host to direct host for migrations
# Neon's -pooler endpoint uses PgBouncer in transaction mode, which breaks transactional DDL with SQLSTATE[25P02].
if echo "${DB_HOST:-}" | grep -q -- "-pooler\."; then
    DIRECT_HOST=$(echo "${DB_HOST}" | sed 's/-pooler\./\./')
    echo "Notice: Neon pooled host detected (${DB_HOST})."
    echo "Using direct host for migrations to prevent PgBouncer transaction aborts: ${DIRECT_HOST}"
    export DB_HOST="${DIRECT_HOST}"
fi

if echo "${DB_URL:-}" | grep -q -- "-pooler\."; then
    export DB_URL=$(echo "${DB_URL}" | sed 's/-pooler\./\./')
fi

if echo "${DATABASE_URL:-}" | grep -q -- "-pooler\."; then
    export DATABASE_URL=$(echo "${DATABASE_URL}" | sed 's/-pooler\./\./')
fi

# Step 4: Mandatory Runtime Verification of PHP PostgreSQL Driver
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

# Step 5: Verify Laravel DB configuration without printing secrets
echo "=== DATABASE CONFIG ==="
echo "DB_CONNECTION=${DB_CONNECTION:-NOT_SET}"
php artisan config:show database.default
php artisan config:show database.connections.pgsql.driver
echo "======================="

# Step 6: Safe read-only database pre-flight inspection
if [ -f "/var/www/html/docker/inspect-db.php" ]; then
    php /var/www/html/docker/inspect-db.php || true
fi

# Step 7: Run database migrations if requested; stop immediately on failure
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running database migrations..."
    if ! php artisan migrate --force; then
        echo "ERROR: Database migration failed."
        echo "Container startup aborted."
        exit 1
    fi
    echo "Database migrations completed successfully."
fi

# Step 8: Ensure LOG_CHANNEL defaults to stderr for container logs
export LOG_CHANNEL="${LOG_CHANNEL:-stderr}"

# Step 9: Verify APP_KEY presence without exposing secrets
if [ -n "${APP_KEY:-}" ]; then
    echo "APP_KEY: Configured"
else
    echo "WARNING: APP_KEY environment variable is NOT SET! Application will throw 500 on web routes."
fi

# Step 10: Cache Laravel configuration, routes, and views
echo "Optimizing Laravel configuration, routes, and views..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Step 11: Guarantee correct permissions for www-data on all generated files
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Step 12: Supervisor starts PHP-FPM + Nginx
exec "$@"
