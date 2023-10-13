# Laravel + Nginx + MySQL with Docker Compose

Setting up Laravel in the local environment with Docker using the LEMP stack that includes: Nginx, MySQL, PHP

## Requisite

- Docker Installed
- Composer Installed

## Create and Download Project's source code from Laravel 

1. ```composer create-project laravel/laravel <project-directory>```
2. ```cd <project-directory>```
3. ```composer install```
4. ```cp .env.example .env```
5. Modify Environment Settings
```sh
DB_CONNECTION=mysql
DB_HOST=db # database container name
DB_PORT=3306
DB_DATABASE=laravel # database name
DB_USERNAME=root # database username
DB_PASSWORD=123456 # <your-laravel-db-password>
```

## Create configuration files

### Configuring PHP
1. ```mkdir ~/<project-directory>/php```
2. ```nano ~/<project-directory>/php/local.ini```
3. Add following code
```sh
upload_max_filesize=40M
post_max_size=40M
```

### Configuring Nginx
1. ```mkdir -p ~/<project-directory>/nginx/conf.d```
2. ```nano ~/<project-directory>/nginx/conf.d/app.conf```
3. Add following code
```sh
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/public;
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}
```

### Configuring MySQL
1. ```mkdir ~/<project-directory>/mysql```
2. ```nano ~/<project-directory>/mysql/my.cnf```
3. Add following code
```sh
[mysqld]
general_log = 1
general_log_file = /var/lib/mysql/general.log
```

## Create docker-compose file
In the ```docker-compose``` file, you will define three services: ```app```, ```webserver```, and ```db```.
Replace <mysql-root-password> under ```db``` service with a strong password.

```yml
version: '3'
services:

  #PHP Service
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: app
    restart: unless-stopped
    tty: true
    environment:
      SERVICE_NAME: app
      SERVICE_TAGS: dev
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./php/local.ini:/usr/local/etc/php/conf.d/local.ini
      - ./src/supervisor:/etc/supervisor/conf.d
    ports:
      - "9000:9000"
    networks:
      - app-network
    
  #Nginx Service
  webserver:
    image: nginx:alpine
    container_name: webserver
    restart: unless-stopped
    tty: true
    ports:
      - "8080:80"
      # - "80:80"
      # - "443:443"
    volumes:
      - ./:/var/www
      - ./nginx/conf.d/:/etc/nginx/conf.d/
    networks:
      - app-network
  
  #MySQL Service
  db:
    image: mysql:8.0.34
    container_name: db
    restart: unless-stopped
    tty: true
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: <mysql-root-password>
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - dbdata:/var/lib/mysql
      - ./mysql/my.cnf:/etc/mysql/my.cnf
    networks:
      - app-network

#Docker Networks
networks:
  app-network:
    driver: bridge

#Volumes
volumes:
  dbdata:
    driver: local

```

## Create Dockerfile

```Dockerfile
FROM php:8.1-fpm

# Copy composer.json and composer.lock
COPY composer.json composer.lock /var/www/

# Set working directoty
WORKDIR /var/www

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

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Start php-fpm server
CMD ["php-fpm"]
```

## Run the containers and execute initial settings 
1. ```docker-compose up -d```
2. ```docker-compose exec app php artisan key:generate```
3. ```docker-compose exec app php artisan config:cache```


## Create a User for MySQL (optional)
1. ```docker-compose exec db bash```
2. ```mysql -u root -p```
3. ```show databases;```
4. ```CREATE USER 'laraveluser'@'%' IDENTIFIED BY '123456';```
5. ```GRANT ALL PRIVILEGES ON laravel.* TO 'laraveluser'@'%';```
6. ```FLUSH PRIVILEGES;```
