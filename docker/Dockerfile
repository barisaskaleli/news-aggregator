FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql sockets pcntl
RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .phpize-deps
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY docker/php-ini-overrides.ini /usr/local/etc/php/conf.d/php-overrides.ini
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
