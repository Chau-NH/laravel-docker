FROM php:8.2-fpm

# Set working directoty
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install dependencies
RUN apt-get update && apt-get install -y --fix-missing \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    supervisor \
    cron

# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog vim

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Install nodejs
RUN apt-get update && apt-get install -y nodejs npm
RUN npm ci

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# RUN npm run dev
# Start php-fpm server
CMD ["php-fpm"]