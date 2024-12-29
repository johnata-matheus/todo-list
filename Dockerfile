FROM php:8.1-fpm

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update \
    && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install zip pdo_mysql\
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html

RUN composer install

EXPOSE 80

CMD ["php-fpm"]
