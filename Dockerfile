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
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-configure zip \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www

COPY ./package*.json ./

# Install the dependencies
RUN npm install

COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Build the application
RUN npm run build


# Install composer dependencies (optional - you can also do this during build)
# RUN composer install --no-dev --optimize-autoloader

EXPOSE 7050

CMD ["php-fpm"]
