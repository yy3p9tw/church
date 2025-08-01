# 部署腳本 - Koyeb 平台

# Dockerfile
FROM php:8.2-apache

# 安裝必要的 PHP 擴展
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath

# 啟用 Apache mod_rewrite
RUN a2enmod rewrite

# 複製應用程式檔案
COPY . /var/www/html/

# 設定權限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/public/uploads \
    && chmod -R 755 /var/www/html/database

# 設定 Apache 虛擬主機
COPY deployment/apache.conf /etc/apache2/sites-available/000-default.conf

# 暴露 80 端口
EXPOSE 80

# 啟動 Apache
CMD ["apache2-foreground"]
