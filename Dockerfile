FROM php:7.4-fpm-alpine

ARG user
ARG uid

RUN apk add --update --no-cache g++ gcc libxslt-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql tokenizer xml pcntl
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer
RUN adduser --disabled-password --ingroup "www-data" --uid $uid --home /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user /home/$user
WORKDIR /var/www

USER $user
