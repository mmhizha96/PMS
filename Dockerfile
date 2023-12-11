FROM php:8.2.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:2.2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN php artisan cache:clear
RUN composer install
