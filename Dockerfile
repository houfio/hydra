FROM php:7.4-fpm-alpine

ARG user
ARG uid

RUN docker-php-ext-install pdo_mysql mbstring gd
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user
WORKDIR /var/www

USER $user
