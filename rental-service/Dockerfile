FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# RUN apt-get update \
#     && apt-get -y --no-install-recommends install  php-xdebug \
#     && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
#     && echo "zend_extension=/usr/lib/php/20160303/xdebug.so" > /etc/php/7.1/mods-available/xdebug.ini \
#     && echo "xdebug.remote_enable=on" >> /etc/php/7.1/mods-available/xdebug.ini \
#     && echo "xdebug.remote_handler=dbgp" >> /etc/php/7.1/mods-available/xdebug.ini \
#     && echo "xdebug.remote_port=9000" >> /etc/php/7.1/mods-available/xdebug.ini \
#     && echo "xdebug.remote_autostart=on" >> /etc/php/7.1/mods-available/xdebug.ini \
#     && echo "xdebug.remote_connect_back=0" >> /etc/php/7.1/mods-available/xdebug.ini \
#     && echo "xdebug.idekey=docker" >> /etc/php/7.1/mods-available/xdebug.ini

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    openssl \
    bash \
    net-tools \
    default-mysql-client \
    nodejs \
    npm \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN yes | pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
# && echo "xdebug.remote_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=192.168.15.39" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
