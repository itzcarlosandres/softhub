#!/bin/bash
echo "🚀 Iniciando despliegue de SoftHub en EasyPanel..."

# Aseguramos permisos de carpetas críticas
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/public/uploads

echo "✅ Todo listo, arrancando servidor Apache..."
exec apache2-foreground
