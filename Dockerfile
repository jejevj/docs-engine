# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies for Laravel (including Composer, Git, and PHP extensions)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    libmemcached-dev \
    curl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@10.9.2

# Install Hugo (latest version)
RUN curl -sL https://github.com/gohugoio/hugo/releases/download/v0.116.1/hugo_0.116.1_Linux-64bit.tar.gz | tar xz -C /usr/local/bin --strip-components=1

# Verify Hugo installation (optional)
RUN hugo version

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Modify PHP configuration settings directly
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize = 128M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size = 128M" >> /usr/local/etc/php/conf.d/custom.ini
    
# Set the working directory in the container
WORKDIR /var/www/html

# Copy the Laravel project into the container (superuser root permissions will apply)
COPY . .

# Install Laravel dependencies using Composer (runs with root access)
# RUN composer install --optimize-autoloader

# Expose port 8000 (for the Laravel development server)
EXPOSE 8000

# Set the command to run the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
