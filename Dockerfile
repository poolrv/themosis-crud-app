FROM php:8.2-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    default-mysql-client libmysqlclient-dev \
    postgresql-client libpq-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Instala extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mysqli zip

# Activa mod_rewrite en Apache
RUN a2enmod rewrite

# Cambia DocumentRoot a htdocs (según tu estructura)
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/htdocs|g' \
    /etc/apache2/sites-available/000-default.conf

# Permite .htaccess en htdocs
RUN printf '<Directory /var/www/html/htdocs>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Copia Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

# Expone explícitamente el puerto 80 para HTTP
EXPOSE 80

CMD ["sh", "-c", "\
  echo '⚙️  Esperando a la base de datos...'; \
  until pg_isready -h \"$DATABASE_HOST\" -p \"$DATABASE_PORT\" -U \"$DATABASE_USER\"; do sleep 2; done; \
  echo '✅  BD lista'; \
  cd /var/www/html; \
  if [ ! -d vendor ]; then \
    echo '📦  composer install'; \
    composer install --no-interaction --optimize-autoloader; \
  fi; \
  echo '🧱  Ejecuto migraciones Themosis'; \
  php console migrate --env=production; \
  echo '🚀  Arrancando Apache'; \
  exec apache2-foreground \
"]
