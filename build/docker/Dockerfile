FROM php:8.2-cli

RUN export DEBIAN_FRONTEND=noninteractive \
    && apt-get update \
    && apt-get install -y \
    wget \
    git \
    libzip-dev \
    zip \
    # Cleanup image
    && apt-get -yqq autoremove \
    && apt-get -yqq clean \
    && rm -rf /var/lib/apt/lists/* /var/cache/* /tmp/* /var/tmp/*

## Install PHP Extensions
RUN docker-php-ext-install pdo_mysql mysqli zip

## Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY ../../ /usr/src/saul
WORKDIR /usr/src/saul
