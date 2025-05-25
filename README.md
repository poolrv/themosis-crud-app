# 🧱 Themosis con Docker

Este proyecto configura un entorno de desarrollo **Themosis Framework** utilizando Docker con Apache, PHP 8.2 y MySQL 8.0. Incluye Composer y soporte para migraciones automáticas al iniciar el contenedor.

## 🚀 Características

- PHP 8.2 con Apache
- MySQL 8.0
- Composer incluido
- Soporte para extensiones necesarias (zip, gd, pdo_mysql, etc.)
- Migraciones automáticas al levantar el contenedor
- Permite `.htaccess` en `public/htdocs` (requerido por Themosis)
- Espera activa a la base de datos antes de iniciar el servidor

## 📁 Estructura esperada

El proyecto espera que los archivos de Themosis estén en la raíz del proyecto, y que el `public/htdocs` contenga el frontend del sitio.

```
/
├── htdocs/
│   └── index.php
├── vendor/
├── composer.json
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## 🐳 Requisitos

- Docker
- Docker Compose

## ⚙️ Instalación y uso

1. Clona este repositorio o coloca tu proyecto Themosis en la misma carpeta que este `Dockerfile`.

2. Ejecuta los contenedores:

```bash
docker-compose up --build
```

3. Accede al sitio en: [http://localhost:8080](http://localhost:8080)

El contenedor `web` esperará a que la base de datos esté lista, luego ejecutará:

- `composer install`
- `php console migrate --env=production`

> 💡 Asegúrate de tener configurado tu archivo `.env` correctamente para el entorno de producción, especialmente las credenciales de base de datos.

## 🔧 Variables de entorno

Estas variables se usan en el contenedor `web` y se configuran en `docker-compose.yml`:

```env
WORDPRESS_DB_HOST=db
WORDPRESS_DB_NAME=themosis
WORDPRESS_DB_USER=themosis
WORDPRESS_DB_PASSWORD=themosis
```

## 📦 Base de datos

El contenedor `db` usa MySQL 8.0, con las siguientes credenciales:

- Usuario: `themosis`
- Contraseña: `themosis`
- Base de datos: `themosis`
- Puerto: `3306`

Los datos se almacenan de forma persistente usando el volumen `dbdata`.

## 🧹 Comandos útiles

- **Reconstruir el entorno desde cero** (borrando volúmenes):

```bash
docker-compose down -v
docker-compose up --build
```

- **Acceder al contenedor web**:

```bash
docker exec -it themosis-web bash
```

- **Acceder al contenedor de base de datos**:

```bash
docker exec -it themosis-db bash
mysql -u themosis -p
```

## 🛠️ Troubleshooting

- Si Composer falla por permisos, asegúrate de que la carpeta `vendor/` y demás tengan permisos adecuados:
  ```bash
  sudo chown -R $(whoami):$(whoami) .
  ```

- Si necesitas reinstalar dependencias:
  ```bash
  docker-compose exec web composer install
  ```

## 🚀 Despliegue en Render

Para desplegar este proyecto en **Render.com**, sigue los siguientes pasos:

### 1. Crear base de datos en Render

- Ve a [Render Dashboard](https://dashboard.render.com/)
- Crea un nuevo servicio de base de datos MySQL
- Copia las credenciales (host, puerto, usuario, contraseña y nombre de base de datos)

### 2. Subir tu repositorio a GitHub

Asegúrate de que tu repositorio contenga:

- `Dockerfile`
- `public/htdocs` con los archivos del sitio
- `.env.production` (o configurar variables en el panel)

### 3. Crear un Web Service en Render

- Elige "Web Service"
- Conecta tu repositorio
- Elige la rama
- Configura:
  - **Build Command:** *(vacío o `echo ok` si usas Dockerfile)*
  - **Start Command:** *(vacío si usas `CMD` en Dockerfile)*
  - **Dockerfile path:** `Dockerfile`

### 4. Configurar variables de entorno

Agrega en Render estas variables de entorno:

```env
WORDPRESS_DB_HOST=<host de la BD en Render>
WORDPRESS_DB_NAME=<nombre de la BD>
WORDPRESS_DB_USER=<usuario>
WORDPRESS_DB_PASSWORD=<contraseña>
```

### 5. Configurar puerto

Render espera que tu aplicación escuche en el puerto definido por la variable `PORT`. Agrega al Dockerfile:

```Dockerfile
ENV PORT=10000
EXPOSE 10000
```
Y en `apache2` configura que escuche en ese puerto:

```Dockerfile
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf
```

---