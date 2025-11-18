# 🛡️ Microservicio de Gestión de Usuarios – Autenticación con Laravel Sanctum

## 📌 Objetivo
Implementar un sistema de autenticación basado en **tokens personales** utilizando **Laravel Sanctum**, permitiendo que los demás microservicios validen solicitudes según el **perfil del usuario**: administrador, editor o usuario común.

---

## 📖 Descripción General
Este microservicio actúa como el núcleo de identidad y autorización del sistema.
Su propósito es emitir, validar y gestionar tokens generados mediante Laravel Sanctum, garantizando un acceso seguro entre los diferentes microservicios.
El microservicio permite:

Cada usuario registrado obtiene un token de acceso personal, el cual es enviado en las peticiones hacia otros servicios. Dicho token:
- Identifica al usuario.
- Define su perfil y permisos.
- Permite validar la autenticidad de las solicitudes.
- Facilita el cierre de sesión y la revocación de tokens.
- Registrar nuevos usuarios con su perfil.
- Iniciar sesión y generar tokens.
- Validar usuarios autenticados mediante token.
- Cerrar sesión eliminando tokens activos.
---
🛠️ Funcionalidades del Microservicio

El sistema implementa un flujo de autenticación completo:

🔹 Registro de Usuarios

Crea nuevos usuarios junto con su perfil (rol).
Los perfiles permiten clasificar permisos según el tipo de usuario:
admin, editor, user, etc.

🔹 Inicio de Sesión

Se validan las credenciales y se genera un token personal mediante Sanctum.
Este token se utilizará en todos los microservicios del ecosistema.

🔹 Validación de Usuario Autenticado

Mediante el token enviado en los encabezados HTTP, se puede identificar de forma segura:

Datos del usuario

Perfil o rol

Permisos relacionados

🔹 Cierre de Sesión

Elimina todos los tokens activos del usuario autenticado, revocando inmediatamente el acceso.
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

