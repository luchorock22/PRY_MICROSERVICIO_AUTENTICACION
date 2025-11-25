# 🛡️ Microservicio de Gestión de Usuarios – Autenticación con Laravel Sanctum

## 📌 Objetivo
Implementar un sistema de autenticación basado en **tokens personales** utilizando **Laravel Sanctum**, permitiendo que los demás microservicios validen solicitudes según el **perfil del usuario**: administrador, editor o usuario común.

---

## 📖 Descripción General
Este microservicio actúa como proveedor de identidad del sistema.  
Su responsabilidad principal es:

- Registrar usuarios.
- Autenticar mediante email y contraseña.
- Generar tokens personales con Sanctum.
- Validar usuarios autenticados.
- Cerrar sesión eliminando tokens.

Los demás microservicios consumirán este servicio para validar solicitudes mediante tokens.

---

## 🛠️ Funcionalidades del Microservicio

### 🔹 Registro de Usuarios
Permite crear usuarios con su perfil (rol):  
`admin`, `editor` o `user`.

### 🔹 Inicio de Sesión
Genera un token personal usando Laravel Sanctum, el cual será enviado a los otros microservicios.

### 🔹 Validación de Usuario Autenticado
Mediante el token enviado por headers, identifica:

- ID del usuario  
- Nombre  
- Email  
- Perfil o rol

### 🔹 Cierre de Sesión
Elimina tokens activos del usuario.

---

## 🛠️ Actividades Realizadas

### 1️⃣ Configuración inicial
- Creación del proyecto Laravel.
- Instalación de **Laravel Sanctum**.
- Configuración del middleware `auth:sanctum`.

---

## 🗄️ 2️⃣ Modelo `User`

El modelo incluye:

- `name`
- `email`
- `password`
- `perfil` (rol del usuario)

Este campo se utiliza para definir los permisos.

---

## 🗄️ 3️⃣ Configuración de Base de Datos (MySQL – XAMPP)

### Crear base de datos:

db_users_auto

### Configurar `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_users_auto
DB_USERNAME=root
DB_PASSWORD=

### Ejecutar migraciones:
```bash

php artisan migrate

### 4️⃣ Controlador de Autenticación
Funciones implementadas:

#### ✔ Registro (`register`)
Guarda datos y devuelve token.

#### ✔ Inicio de sesión (`login`)
Verifica credenciales y genera un nuevo token.

#### ✔ Cierre de sesión (`logout`)
Elimina los tokens del usuario autenticado.

### 5 Rutas API
| Método | Ruta | Acción |
|--------|------|--------|
| POST | `/api/register` | Registro de usuario |
| POST | `/api/login` | Inicio de sesión |
| POST | `/api/logout` | Cierre de sesión |
| GET  | `/api/user` | Ruta protegida: datos del usuario |

Las rutas protegidas usan:
```php
middleware('auth:sanctum')

