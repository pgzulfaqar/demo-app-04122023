FROM php:8.0-fpm

RUN apt-get update && apt-get install -y  \
    libmagickwand-dev \
    --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql

# Configure LDAP.
#RUN apt-get update \
#    && apt-get install libldap2-dev -y \
#    && rm -rf /var/lib/apt/lists/* \
#    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
#    && docker-php-ext-install ldap

# Install GIT / Unzip / Zip
RUN apt-get update \ 
    && apt-get install zip -y  \
    && apt-get install unzip -y \
    && apt-get install git -y

RUN printf '#!/bin/sh\nexit 0' > /usr/sbin/policy-rc.d

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 80