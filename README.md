Microservicio de Gestión de Usuarios con Laravel Sanctum
🧩 Objetivo

Implementar un sistema de autenticación mediante Laravel Sanctum dentro del microservicio de Gestión de Usuarios, permitiendo que los demás microservicios validen solicitudes utilizando tokens de usuario según su perfil: administrador, editor o usuario común.

📝 Descripción General

Este microservicio implementa autenticación basada en tokens personales generados por Laravel Sanctum.
Cada usuario registrado obtiene un token único para interactuar con otros microservicios del sistema.
Mediante este token se valida:

Identidad del usuario autenticado

Perfil asignado (admin, editor, user)

Permisos según el recurso solicitado

El microservicio se encarga de:

Registrar usuarios

Autenticar usuarios y generar tokens

Validar el usuario autenticado

Cerrar sesión e invalidar tokens

🚀 Actividades Realizadas
1️⃣ Configuración del entorno
Instalar Sanctum:
composer require laravel/sanctum

Publicar archivos de configuración:
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

Migrar tablas:
php artisan migrate

Agregar middleware en app/Http/Kernel.php:
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

2️⃣ Definición del Modelo Usuario

En app/Models/User.php:

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

3️⃣ Controlador de Autenticación

Ejemplo de controlador AuthController.php:

Registro
public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,editor,user'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Usuario registrado correctamente',
        'token' => $token
    ]);
}

Inicio de sesión
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Inicio de sesión exitoso',
        'token' => $token
    ]);
}

Cierre de sesión (Logout)
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Sesión cerrada correctamente'
    ]);
}

4️⃣ Rutas de la API

En routes/api.php:

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

5️⃣ Pruebas en Postman
✔ Registrar usuario
POST /api/register
Body (JSON):
{
  "name": "Kelly",
  "email": "kelly@example.com",
  "password": "123456",
  "role": "admin"
}

✔ Iniciar sesión
POST /api/login
Body (JSON):
{
  "email": "kelly@example.com",
  "password": "123456"
}


La respuesta incluye un token.

✔ Consultar ruta protegida
GET /api/user
Headers:
Authorization: Bearer {token}

✔ Cerrar sesión
POST /api/logout
Headers:
Authorization: Bearer {token}


Luego probar nuevamente /api/user → Debe dar 401 Unauthorized.
