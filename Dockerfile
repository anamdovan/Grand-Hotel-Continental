# =====================================================================
#  Dockerfile - Imagen del contenedor de la aplicación Laravel
# =====================================================================

FROM php:8.2-apache

# Actualiza paquetes e instala las extensiones que necesita Laravel
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilita el módulo rewrite de Apache (Laravel lo necesita para que
# funcionen sus rutas con URLs amigables, sin el index.php delante).
RUN a2enmod rewrite

# Cambia el DocumentRoot de Apache a /var/www/html/public, que es donde
# vive el index.php de Laravel.
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copia Composer desde la imagen oficial (gestor de dependencias PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio donde vivirá el código de la aplicación dentro del contenedor
WORKDIR /var/www/html

# Apache expone el puerto 80 (HTTP)
EXPOSE 80

# Comando que arranca Apache cuando se inicia el contenedor
CMD ["apache2-foreground"]
