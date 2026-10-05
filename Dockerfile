# # ==========================================
# # Stage 1: Build Frontend Assets with Node & Vite
# # ==========================================
# FROM node:20-alpine AS frontend-builder
# WORKDIR /app

# COPY package*.json ./
# RUN npm ci

# COPY resources ./resources
# COPY public ./public
# COPY vite.config.js ./
# RUN npm run build

# # ==========================================
# # Stage 2: Install PHP Dependencies with Composer
# # ==========================================
# FROM composer:2 AS composer-builder
# WORKDIR /app

# COPY composer.json composer.lock ./
# RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# COPY . .
# RUN composer dump-autoload --optimize --no-dev

# # ==========================================
# # Stage 3: Production Runtime (PHP-FPM + Nginx)
# # ==========================================
# FROM php:8.2-fpm-alpine

# WORKDIR /var/www/html

# # Install system dependencies
# RUN apk add --no-cache \
#     nginx \
#     supervisor \
#     curl \
#     bash \
#     libpng \
#     libjpeg-turbo \
#     freetype \
#     libzip \
#     icu-libs

# # Install PHP extensions using reliable installer
# COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
# RUN install-php-extensions \
#     bcmath \
#     curl \
#     exif \
#     gd \
#     intl \
#     mbstring \
#     opcache \
#     pdo_mysql \
#     pdo_sqlite \
#     zip

# # Create required directories for Nginx and Supervisor
# RUN mkdir -p /run/nginx /var/log/supervisor /etc/nginx/http.d /etc/nginx/conf.d

# # Copy server & PHP configurations
# COPY docker/nginx.conf /etc/nginx/http.d/default.conf
# COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
# COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
# COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# RUN chmod +x /usr/local/bin/entrypoint.sh

# # Copy application source and vendor from composer-builder
# COPY --from=composer-builder --chown=www-data:www-data /app /var/www/html

# # Copy compiled frontend assets from frontend-builder
# COPY --from=frontend-builder --chown=www-data:www-data /app/public/build /var/www/html/public/build

# # Ensure proper permissions for storage and cache
# RUN mkdir -p /var/www/html/storage/framework/cache/data \
#              /var/www/html/storage/framework/sessions \
#              /var/www/html/storage/framework/views \
#              /var/www/html/storage/logs \
#              /var/www/html/bootstrap/cache && \
#     chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
#     chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# EXPOSE 80

# HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
#     CMD curl -f http://127.0.0.1/ || exit 1

# ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN php artisan optimize

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT}