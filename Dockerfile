FROM php:8.1-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    librabbitmq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

# Установка расширения AMQP
RUN pecl install amqp && docker-php-ext-enable amqp

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка Redis расширения
RUN pecl install redis && docker-php-ext-enable redis

# Установка Node.js (опционально, если нужен)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Рабочая директория
WORKDIR /srv