# VentasFix Backoffice

Sistema de gestión backoffice para la empresa VentasFix, desarrollado con **Laravel 11** y **Laravel Sanctum**.  
Examen Final — Desarrollo de Software Web I — Instituto Profesional San Sebastián.

---

## Tecnologías utilizadas

| Tecnología | Versión | Rol |
|---|---|---|
| PHP | ≥ 8.2 | Lenguaje backend |
| Laravel | 11.x | Framework principal |
| Laravel Sanctum | 4.x | Autenticación API (Bearer Token) |
| MySQL | 8.x | Base de datos |
| Bootstrap | 5.3 | Estilos del template |
| Bootstrap Icons | 1.11 | Iconografía |

---

## Estructura del proyecto

```
ventasfix/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   └── LoginController.php        # Login/Logout web
│   │       ├── Api/
│   │       │   ├── AuthController.php         # Login/Logout API (Sanctum)
│   │       │   ├── UserController.php         # CRUD usuarios (API)
│   │       │   ├── ProductController.php      # CRUD productos (API)
│   │       │   └── ClientController.php       # CRUD clientes (API)
│   │       ├── DashboardController.php        # Dashboard con conteos
│   │       ├── UserController.php             # CRUD usuarios (Web)
│   │       ├── ProductController.php          # CRUD productos (Web)
│   │       └── ClientController.php           # CRUD clientes (Web)
│   └── Models/
│       ├── User.php                           # Modelo usuario (HasApiTokens)
│       ├── Product.php                        # Modelo producto
│       └── Client.php                         # Modelo cliente
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_products_table.php
│   │   ├── ..._create_clients_table.php
│   │   └── ..._create_personal_access_tokens_table.php
│   └── seeders/
│       └── DatabaseSeeder.php                 # Datos de ejemplo + admin
├── resources/views/
│   ├── layouts/app.blade.php                  # Layout principal con sidebar
│   ├── auth/login.blade.php                   # Pantalla de login
│   ├── dashboard/index.blade.php              # Dashboard con estadísticas
│   ├── users/{index,create,edit}.blade.php    # Vistas de usuarios
│   ├── products/{index,create,edit}.blade.php # Vistas de productos
│   └── clients/{index,create,edit}.blade.php  # Vistas de clientes
├── routes/
│   ├── web.php                                # Rutas del sistema web
│   └── api.php                                # Rutas de la API REST
├── .env.example
└── README.md
```

---

## Instalación paso a paso

### Requisitos previos
- PHP 8.2+
- Composer
- MySQL 8+
- Node.js (opcional, para compilar assets)

---

### 1. Clonar o descomprimir el proyecto

```bash
# Descomprime el archivo EXF_APELLIDO_NOMBRE.zip
# Luego entra al directorio:
cd ventasfix
```

---

### 2. Instalar dependencias PHP

```bash
composer install
```

---

### 3. Configurar el archivo de entorno

```bash
# Copia el ejemplo
cp .env.example .env

# Genera la clave de la aplicación
php artisan key:generate
```

Edita `.env` con tus credenciales de MySQL:

```env
DB_DATABASE=ventasfix
DB_USERNAME=root
DB_PASSWORD=tu_password
```

---

### 4. Crear la base de datos

En MySQL/phpMyAdmin, crea la base de datos:

```sql
CREATE DATABASE ventasfix CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### 5. Ejecutar migraciones y seeder

```bash
# Crea todas las tablas
php artisan migrate

# Inserta datos de ejemplo (usuario admin + producto + cliente)
php artisan db:seed
```

> **Credenciales del administrador creado por el seeder:**  
> Email: `admin@ventasfix.cl`  
> Password: `Admin1234`

---

### 6. Instalar Sanctum (si no está instalado)

```bash
php artisan install:api
```

---

### 7. Configurar el link de storage (para imágenes)

```bash
php artisan storage:link
```

---

### 8. Copiar el template de la empresa

Descomprime el template entregado por la empresa y copia su contenido en:

```
public/template/
├── css/
│   ├── bootstrap.min.css
│   └── style.css
└── js/
    └── bootstrap.bundle.min.js
```

---

### 9. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Accede en: **http://localhost:8000**

---

## Módulos del sistema

### Sistema Web (Backoffice)

| Ruta | Descripción |
|---|---|
| `GET /login` | Formulario de inicio de sesión |
| `POST /login` | Procesar login |
| `POST /logout` | Cerrar sesión |
| `GET /dashboard` | Dashboard con conteos |
| `GET /users` | Listado de usuarios |
| `GET /users/create` | Formulario crear usuario |
| `POST /users` | Guardar nuevo usuario |
| `GET /users/{id}/edit` | Formulario editar usuario |
| `PUT /users/{id}` | Actualizar usuario |
| `DELETE /users/{id}` | Eliminar usuario |
| `GET /products` | Listado de productos |
| `GET /products/create` | Formulario crear producto |
| `POST /products` | Guardar nuevo producto |
| `GET /products/{id}/edit` | Formulario editar producto |
| `PUT /products/{id}` | Actualizar producto |
| `DELETE /products/{id}` | Eliminar producto |
| `GET /clients` | Listado de clientes |
| `GET /clients/create` | Formulario crear cliente |
| `POST /clients` | Guardar nuevo cliente |
| `GET /clients/{id}/edit` | Formulario editar cliente |
| `PUT /clients/{id}` | Actualizar cliente |
| `DELETE /clients/{id}` | Eliminar cliente |

---

### API REST (prefijo `/api`)

Todas las rutas protegidas requieren el header:  
`Authorization: Bearer {token}`

#### Autenticación

| Método | Endpoint | Descripción | Auth |
|---|---|---|---|
| POST | `/api/login` | Obtener token de acceso | No |
| POST | `/api/logout` | Revocar token actual | Sí |

**Body de login:**
```json
{
    "email": "admin@ventasfix.cl",
    "password": "Admin1234"
}
```

**Respuesta exitosa (200):**
```json
{
    "message": "Autenticación exitosa.",
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
        "id": 1,
        "nombre": "Administrador",
        "apellido": "Sistema",
        "email": "admin@ventasfix.cl"
    }
}
```

---

#### Usuarios

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/users` | Listar todos los usuarios |
| GET | `/api/users/{id}` | Obtener usuario por ID |
| POST | `/api/users` | Crear nuevo usuario |
| PUT | `/api/users/{id}` | Actualizar usuario |
| DELETE | `/api/users/{id}` | Eliminar usuario |

**Body POST/PUT:**
```json
{
    "rut": "12345678-9",
    "nombre": "Juan",
    "apellido": "Pérez",
    "email": "juan@ventasfix.cl",
    "password": "secret123"
}
```

---

#### Productos

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/products` | Listar todos los productos |
| GET | `/api/products/{id}` | Obtener producto por ID |
| POST | `/api/products` | Crear nuevo producto |
| PUT | `/api/products/{id}` | Actualizar producto |
| DELETE | `/api/products/{id}` | Eliminar producto |

**Body POST:**
```json
{
    "sku": "PROD-001",
    "nombre": "Teclado USB",
    "descripcion_corta": "Teclado USB 104 teclas",
    "descripcion_larga": "Descripción completa del producto...",
    "imagen": "teclado.jpg",
    "precio_neto": 15000,
    "stock_actual": 50,
    "stock_minimo": 5,
    "stock_bajo": 10,
    "stock_alto": 100
}
```

> **Nota:** El campo `precio_venta` no se envía. Es calculado automáticamente por el backend aplicando IVA del 19% (`precio_neto × 1.19`).

---

#### Clientes

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/clients` | Listar todos los clientes |
| GET | `/api/clients/{id}` | Obtener cliente por ID |
| POST | `/api/clients` | Crear nuevo cliente |
| PUT | `/api/clients/{id}` | Actualizar cliente |
| DELETE | `/api/clients/{id}` | Eliminar cliente |

**Body POST/PUT:**
```json
{
    "rut_empresa": "76123456-7",
    "rubro": "Tecnología",
    "razon_social": "Empresa SA",
    "telefono": "+56912345678",
    "direccion": "Av. Principal 123, Santiago",
    "nombre_contacto": "Ana González",
    "email_contacto": "ana@empresa.cl"
}
```

---

## Códigos de respuesta HTTP

| Código | Significado | Cuándo se usa |
|---|---|---|
| 200 | OK | Operación exitosa (GET, PUT, DELETE) |
| 201 | Created | Registro creado exitosamente (POST) |
| 401 | Unauthorized | Token inválido o ausente |
| 404 | Not Found | Registro no encontrado |
| 422 | Unprocessable Entity | Error de validación |

---

## Seguridad implementada

- **Contraseñas cifradas:** se utiliza el algoritmo `bcrypt` mediante `Hash::make()`. Las contraseñas nunca se almacenan en texto plano.
- **Autenticación web:** sesiones Laravel con protección CSRF en todos los formularios (`@csrf`).
- **Autenticación API:** tokens Bearer mediante Laravel Sanctum. Cada token es único por sesión. Al hacer logout, el token es revocado de la base de datos.
- **Validaciones:** todos los campos son obligatorios. El email de usuarios debe pertenecer al dominio `@ventasfix.cl`.
- **Auto-protección:** un usuario no puede eliminarse a sí mismo desde el sistema web.

---

## Datos del estudiante

- **Nombre:** Eduardo Palma  
- **Institución:** Instituto Profesional San Sebastián  
- **Carrera:** Promgacion y analisis de sistemas 
- **Asignatura:** Desarrollo de Software Web I  
- **GitHub:** @EdwardWaldo  
- **Archivo comprimido:** `EXF_Palma_Eduardo.zip`

---

## Comandos útiles de referencia

```bash
# Ver todas las rutas registradas
php artisan route:list

# Revertir y re-ejecutar migraciones + seeder
php artisan migrate:fresh --seed

# Limpiar caché de configuración
php artisan config:clear && php artisan cache:clear

# Ver logs de error
tail -f storage/logs/laravel.log
```
