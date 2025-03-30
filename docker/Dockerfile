FROM php:8.3-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git curl zip unzip libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libssl-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install  \
      gd \
      opcache \
      pdo_mysql \
      mbstring \
      zip \
      exif \
      pcntl \
      bcmath \
      intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Ensure supervisord and nginx can write to the log directory
RUN mkdir -p /var/log/supervisord /var/run/supervisord

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel source code
COPY . /var/www

# Copy configs from the docker/ folder (relative to build context)
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache \
    && chmod +x /entrypoint.sh

# Install PHP dependencies (production only)
RUN composer install --no-dev --prefer-dist --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose HTTP
EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["default"]
