FROM php:8.2-apache

# 1. Instala extensiones y cliente MySQL
RUN apt-get update \
 && apt-get install -y \
      libzip-dev zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
      default-mysql-client \
 && docker-php-ext-install pdo pdo_mysql mysqli zip

# 2. Activa mod_rewrite
RUN a2enmod rewrite

# 3. Cambia DocumentRoot a htdocs (Themosis usa public/htdocs)
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/htdocs|g' \
    /etc/apache2/sites-available/000-default.conf

# 4. Permitir .htaccess en htdocs
RUN printf '<Directory /var/www/html/htdocs>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' \
    >> /etc/apache2/apache2.conf

# 5. Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Ajusta propietarios
RUN chown -R www-data:www-data /var/www/html

CMD ["sh", "-c", "\
  echo '⚙️  Esperando a la base de datos...'; \
  until mysqladmin ping -h\"$WORDPRESS_DB_HOST\" --silent; do sleep 2; done; \
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
