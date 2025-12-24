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
    libicu-dev \
    libxpm-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_mysql zip gd intl


# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@10.9.2

# Install Hugo (latest version)
RUN curl -sL https://github.com/gohugoio/hugo/releases/download/v0.153.2/hugo_0.153.2_Linux-64bit.tar.gz -o /tmp/hugo.tar.gz \
    && tar -xzvf /tmp/hugo.tar.gz -C /usr/local/bin \
    && chmod +x /usr/local/bin/hugo \
    && echo "Hugo installed at: $(which hugo)" \
    && hugo version

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Modify PHP configuration settings directly
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize = 128M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size = 128M" >> /usr/local/etc/php/conf.d/custom.ini

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the Laravel project into the container
COPY . .

# Ensure proper ownership of files
RUN chown -R www-data:www-data /var/www/html

# Install project dependencies using Composer
# RUN composer install --no-dev --optimize-autoloader
COPY .env .env.docker


# Expose port 8000 (for the Laravel development server)
EXPOSE 8000

# Set the command to run the Laravel development server
