FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    vim \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html
COPY --chown=www-data:www-data . /var/www/html
RUN chmod -R 755 /var/www/html

RUN cp .env.example .env

RUN composer install && php artisan key:generate

RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite

RUN php artisan migrate --force

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
