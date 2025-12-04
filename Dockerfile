FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk --no-cache add \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-configure zip \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer (Laravel's dependency manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy your Laravel project into the container
COPY . /var/www

# Install composer dependencies (optional - you can also do this during build)
# RUN composer install --no-dev --optimize-autoloader

EXPOSE 7050

CMD ["php-fpm"]
