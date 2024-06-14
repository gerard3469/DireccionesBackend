# Libreta de Direcciones - Backend

Este proyecto es el backend de una aplicación de libreta de direcciones avanzada, construida con Laravel.

## Requisitos

- PHP >= 7.4
- Composer
- MySQL
- Node.js y NPM (para herramientas como Laravel Mix)

## Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/tu-usuario/libreta-direcciones-backend.git
cd libreta-direcciones-backend
```
2. Instala las dependencias de PHP:
```bash
composer install
```
3. Copia el archivo .env.example a .env y configura tus variables de entorno
```bash
cp .env.example .env
```
4. Configura tu base de datos en el archivo .env:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
5. Ejecuta las migraciones y seeders para crear y poblar la base de datos:
```bash
php artisan migrate --seed
```
6. Inicia el servidor de desarrollo:
```bash
php artisan serve
```

## Endpoints
Los endpoints principales de la API incluyen:

- GET /api/contacts - Listar contactos con paginación
- GET /api/contacts/{id} - Obtener detalles de un contacto específico
- POST /api/contacts - Crear un nuevo contacto
- PUT /api/contacts/{id} - Actualizar un contacto existente
- DELETE /api/contacts/{id} - Eliminar un contacto

## Contribuir
Las contribuciones son bienvenidas. Por favor, abre un issue o envía un pull request.

## Licencia
Este proyecto está licenciado bajo la Licencia MIT.
