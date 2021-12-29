FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    librdkafka-dev \
    nano \
    openssl \
    bash \
    nginx \
    openrc \
    default-mysql-client \
    nodejs \
    npm \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /run/nginx && \
    echo "pid /run/nginx.pid;" >> /etc/nginx/nginx.conf

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN pecl install rdkafka

RUN ln -s /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    echo "extension=rdkafka.so" >> /usr/local/etc/php/php.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# RUN rm /etc/nginx/conf.d/default.conf
COPY .docker/nginx/nginx.conf /etc/nginx/conf.d

COPY . .
RUN chmod -R 777 /var/www/storage/

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
chown -R $user:$user /home/$user


USER $user

EXPOSE 80
ENTRYPOINT ["/var/www/entrypoint.sh"]
