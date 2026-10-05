# ==========================================
# Shiv Aaradhana Private Limited — Production Dockerfile
# Standalone PHP 8.3-FPM + High-Performance Nginx + Supervisor
# Zero Node.js / Zero Vite Dependency
# ==========================================

# Stage 1: Vendor Dependencies Builder
FROM composer:2 AS vendor-builder
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-reqs

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Stage 2: Production Runtime (PHP-FPM + Nginx + Supervisor)
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Install production system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    bash \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    icu-libs \
    libpq \
    postgresql-client \
    postgresql-dev

# Install required PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    bcmath \
    curl \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    pgsql \
    pdo_pgsql \
    pdo_mysql \
    pdo_sqlite \
    zip

# Build-time verification: Docker build will FAIL if PDO, pdo_pgsql, or pgsql is missing
RUN php -r "extension_loaded('PDO') || (fwrite(STDERR, 'FATAL: PDO extension is not loaded\n') && exit(1));" \
    && php -r "extension_loaded('pdo_pgsql') || (fwrite(STDERR, 'FATAL: pdo_pgsql driver is missing\n') && exit(1));" \
    && php -r "extension_loaded('pgsql') || (fwrite(STDERR, 'FATAL: pgsql driver is missing\n') && exit(1));" \
    && php -r "in_array('pgsql', PDO::getAvailableDrivers()) || (fwrite(STDERR, 'FATAL: pgsql is not in PDO getAvailableDrivers\n') && exit(1));" \
    && echo "=== POSTGRESQL EXTENSIONS VERIFIED AT BUILD TIME ===" \
    && php -m | grep -E 'PDO|pdo_pgsql|pgsql'

# Create required directories for Nginx and Supervisor
RUN mkdir -p /run/nginx /var/log/supervisor /etc/nginx/http.d /etc/nginx/conf.d

# Copy server & PHP configurations
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application source and optimized vendor from vendor-builder
COPY --from=vendor-builder --chown=www-data:www-data /app /var/www/html

# Ensure proper permissions for storage and cache
RUN mkdir -p /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

ENV PORT=80
EXPOSE 80 10000

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://127.0.0.1:${PORT}/health || curl -f http://127.0.0.1:${PORT}/ || exit 0

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
