FROM php:8.2-apache
# 1. Instalar dependencias del sistema y extensiones PHP necesarias para Laravel y Postgres
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Configurar Apache para apuntar a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# 3. Copiar archivos del proyecto
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Instalar Composer de forma segura
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 5. Permisos cruciales (Aseguramos que Laravel pueda escribir logs y caché)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 6. Exponer puerto 80
EXPOSE 80

# 7. Comando de inicio mejorado
# El "|| true" evita que el contenedor muera si la migración falla temporalmente
CMD php artisan migrate --force || true && apache2-foreground
