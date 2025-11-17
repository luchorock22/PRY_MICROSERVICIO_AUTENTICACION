# 🛡️ Microservicio de Gestión de Usuarios – Autenticación con Laravel Sanctum

## 📌 Objetivo
Implementar un sistema de autenticación basado en **tokens personales** utilizando **Laravel Sanctum**, permitiendo que los demás microservicios validen solicitudes según el **perfil del usuario**: administrador, editor o usuario común.

---

## 📖 Descripción General
Este microservicio funciona como el **punto central de autenticación** dentro del sistema.  
Permite que cada usuario registrado obtenga un **token personal** que utilizará para acceder a otros microservicios.

El microservicio permite:

- Registrar nuevos usuarios con su perfil.
- Iniciar sesión y generar tokens.
- Validar usuarios autenticados mediante token.
- Cerrar sesión eliminando tokens activos.

---

## 🛠️ Actividades Realizadas

### 1️⃣ Configuración del entorno
- Creación de proyecto Laravel.
- Instalación de Laravel Sanctum.
- Configuración del middleware `auth:sanctum` para rutas protegidas.

### 2️⃣ Modelo de Usuario
El modelo `User` contiene:

- `name`
- `email`
- `password`
- `perfil` (rol del usuario)

Este campo permite diferenciar permisos entre usuarios.

### 3️⃣ Controlador de Autenticación
Funciones implementadas:

#### ✔ Registro (`register`)
Guarda datos y devuelve token.

#### ✔ Inicio de sesión (`login`)
Verifica credenciales y genera un nuevo token.

#### ✔ Cierre de sesión (`logout`)
Elimina los tokens del usuario autenticado.

### 4️⃣ Rutas API
| Método | Ruta | Acción |
|--------|------|--------|
| POST | `/api/register` | Registro de usuario |
| POST | `/api/login` | Inicio de sesión |
| POST | `/api/logout` | Cierre de sesión |
| GET  | `/api/user` | Ruta protegida: datos del usuario |

Las rutas protegidas usan:
```php
middleware('auth:sanctum')

