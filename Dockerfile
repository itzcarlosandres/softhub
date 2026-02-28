FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache to serve from /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Set permissions for storage or uploads if needed
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Grant execution rights and fix line endings for Linux
RUN sed -i 's/\r$//' /var/www/html/deploy.sh \
    && cp /var/www/html/deploy.sh /deploy.sh \
    && chmod +x /deploy.sh

# Expose port 80
EXPOSE 80

# Use the deployment script as the CMD
CMD ["/deploy.sh"]
