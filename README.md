# Grand Hotel Continental – Bucarest

Sistema web completo para la gestión de un hotel boutique de 5 estrellas en Bucarest.
Permite al cliente consultar el catálogo de habitaciones, reservar online y dejar opiniones,
y al personal del hotel administrar reservas, habitaciones, servicios, opiniones, mensajes
y usuarios desde un panel privado.

Proyecto FTG del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web.


## Características principales

- Catálogo público de habitaciones con galería de imágenes y detalle por habitación.
- Sistema de reservas online con cálculo automático del precio en tiempo real.
- Selección de servicios extras (desayuno, parking, spa, transfer, etc.) al reservar.
- Sistema de opiniones y valoraciones por estrellas tras la estancia.
- Formulario de contacto con bandeja de mensajes para el personal del hotel.
- Panel de administración con tablas dinámicas (DataTables + AJAX).
- Dashboard con tres gráficas estadísticas (reservas por mes, habitaciones más
  reservadas y habitaciones mejor valoradas) hechas con Chart.js.
- Sistema de roles con tres perfiles (administrador, recepcionista y cliente)
  y middleware propio que protege las rutas.
- API REST que devuelve JSON para consumir desde el frontend.
- Validaciones de email, contraseña y nombre tanto en cliente (JavaScript) como
  en servidor (Laravel).
- Diseño responsive con Bootstrap 5 (móvil, tablet y escritorio).


## Tecnologías utilizadas

| Capa | Tecnología |
|------|------------|
| Backend | PHP 8.2 + Laravel 12 |
| Base de datos | MariaDB 10.11 |
| ORM | Eloquent |
| Frontend | HTML5, CSS3 (Bootstrap 5.0.2), JavaScript ES6, SASS |
| Librerías JS | jQuery, DataTables 2.2, Chart.js |
| Iconos | Bootstrap Icons |
| Servidor | Apache 2.4 |
| Despliegue | Docker + Docker Compose (3 contenedores: app, db, pma) |
| Control de versiones | Git + GitHub |


## Requisitos previos

- PHP 8.2 o superior
- Composer
- MariaDB / MySQL (incluido en XAMPP)
- Apache (incluido en XAMPP)
- Git


## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/anamdovan/Grand-Hotel-Continental.git
   cd Grand-Hotel-Continental
   ```

2. Instalar las dependencias de PHP:
   ```bash
   composer install
   ```

3. Crear el archivo de configuración a partir del ejemplo:
   ```bash
   cp .env.example .env
   ```

4. Generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

5. Crear una base de datos vacía en MariaDB con el nombre `grand_hotel_continental`
   y actualizar las credenciales en el archivo `.env`:
   ```env
   DB_DATABASE=grand_hotel_continental
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Ejecutar las migraciones y los seeders (creará todas las tablas y datos de prueba):
   ```bash
   php artisan migrate:fresh --seed
   ```

7. Arrancar XAMPP (Apache + MariaDB) y entrar en el navegador:
   ```
   http://localhost/Grand-Hotel-Continental/public/
   ```


## Despliegue con Docker

El proyecto incluye un `Dockerfile` y un `docker-compose.yml` que orquesta
**3 contenedores**: la aplicación (Laravel + Apache + PHP 8.2), la base de
datos (MariaDB) y phpMyAdmin para administrar la base de datos.

**Requisito:** tener [Docker Desktop](https://www.docker.com/products/docker-desktop/)
instalado y arrancado.

**1. Levantar los tres contenedores:**
```bash
docker-compose up -d --build
```

**2. Configurar Laravel dentro del contenedor (solo la primera vez):**
```bash
docker-compose exec app bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
exit
```

**3. Acceder a la aplicación:**
- Hotel: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (usuario `laravel`, contraseña `laravel1234`)

**Comandos útiles:**
| Comando | Para qué |
|---|---|
| `docker-compose up -d` | Arrancar los contenedores (sin reconstruir) |
| `docker-compose down` | Parar los contenedores |
| `docker-compose logs app` | Ver los logs del contenedor de la app |
| `docker ps` | Listar contenedores en ejecución |


## Usuarios de prueba

Tras ejecutar los seeders, puedes iniciar sesión con estos usuarios:

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | anamoldov@gmail.com | Admin1234 |
| Recepcionista | carmen@gmail.com | Recepcion1234 |
| Recepcionista | sergiungur@gmail.com | Recepcion1234 |
| Cliente | elisasos@gmail.com | User1234 |
| Cliente | luciagarcia@gmail.com | User1234 |

Hay 10 clientes adicionales más, todos con contraseña `User1234`.


## Estructura del proyecto

```
Grand-Hotel-Continental/
├── app/
│   ├── Http/
│   │   ├── Controllers/   → Controladores (Reservas, Habitaciones, Usuarios...)
│   │   └── Middleware/    → CheckRole (control de acceso por rol)
│   └── Models/            → Modelos Eloquent (Reserva, Habitacion, User...)
├── database/
│   ├── migrations/        → Definición del esquema de la BD
│   └── seeders/           → Datos de prueba iniciales
├── public/
│   └── assets/
│       ├── css/           → Estilos
│       ├── js/            → Lógica del cliente (validaciones, tablas, gráficas)
│       └── img/           → Imágenes de habitaciones
├── resources/
│   └── views/             → Plantillas Blade
│       ├── layouts/       → Layouts público y admin
│       └── ...
└── routes/
    └── web.php            → Definición de todas las rutas (web + API)
```


## Funcionalidades por rol

**Cliente**
- Registrarse y acceder a su cuenta.
- Consultar el catálogo de habitaciones.
- Ver el detalle y reservar.
- Añadir servicios extras a la reserva.
- Cancelar sus propias reservas.
- Dejar opinión sobre las reservas completadas.
- Enviar mensajes al hotel desde el formulario de contacto.

**Recepcionista**
- Gestionar reservas (crear, editar).
- Gestionar pagos.
- Gestionar habitaciones (crear, editar).
- Ver y responder mensajes de clientes.
- Acceder al dashboard estadístico.

**Administrador**
- Todo lo anterior, además de:
- Eliminar reservas, habitaciones, pagos, opiniones y mensajes.
- Gestionar usuarios (alta, edición y eliminación).
- Gestionar servicios extras del hotel.


## Autora

**Ana Maria Moldovan Rus**
Proyecto Final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web.
2026.
