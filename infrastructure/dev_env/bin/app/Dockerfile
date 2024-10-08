FROM php:8.2-apache

LABEL maintainer="Ratko Nikolovski"

ARG DEBIAN_FRONTEND=noninteractive

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*


# Install useful tools and install important libaries
RUN apt-get -y update && \
    apt-get -y --no-install-recommends install nano wget \
        dialog \
        vim \
        libpq-dev \
        libmemcached-dev \
        curl \
        htop \
        libsqlite3-dev \
        libsqlite3-0 && \
    apt-get -y --no-install-recommends install default-mysql-client \
        zlib1g-dev \
        libzip-dev \
        libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing apt-utils \
        build-essential \
        git \
        curl \
        libonig-dev && \
    apt-get -y --no-install-recommends install --fix-missing libcurl4 \
        libcurl4-openssl-dev \
        zip \
        openssl && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug-3.2.2 && \
    docker-php-ext-enable xdebug

# Install imagick
RUN apt-get update && \
    apt-get -y --no-install-recommends install --fix-missing libmagickwand-dev && \
    rm -rf /var/lib/apt/lists/* && \
    pecl install imagick && \
    docker-php-ext-enable imagick

# Install Redis PHP Extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Other PHP8 Extensions
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo_sqlite && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install curl && \
    docker-php-ext-install zip && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install gettext && \
    docker-php-ext-install calendar && \
    docker-php-ext-install exif


# Install Freetype
RUN apt-get -y update && \
    apt-get --no-install-recommends install -y libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Enable apache modules
RUN a2enmod rewrite headers
RUN a2enmod proxy_http
RUN a2enmod proxy


# Install Memcached
RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/refs/tags/v3.1.5.tar.gz" \
    && mkdir -p /usr/src/php/ext/memcached \
    && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
    && docker-php-ext-configure memcached --disable-memcached-sasl \
    && docker-php-ext-install memcached \
    && rm /tmp/memcached.tar.gz
