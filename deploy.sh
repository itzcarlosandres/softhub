#!/bin/bash
set -e

# Change directory to the web root
cd /var/www/html

# Ensure proper permissions for important folders
echo "Configuring permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/public/uploads
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/public/uploads

# Start Apache in the foreground
echo "Starting Apache..."
apache2-foreground
