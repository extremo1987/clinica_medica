INTEGRACIÓN: Parte 1 - Login y Gestión de Usuarios (Roles/Permisos)
---------------------------------------------------------------

Archivos incluidos en este paquete (pega dentro de la raíz de tu proyecto Laravel):

1) Controlador:
   - app/Http/Controllers/Admin/UserController.php

2) Vistas (Tabler):
   - resources/views/admin/users/index.blade.php
   - resources/views/admin/users/create.blade.php
   - resources/views/admin/users/edit.blade.php

3) Seeder:
   - database/seeders/RolesSeeder.php

PASOS PARA INTEGRAR:

1) Instala Spatie Permission (si no lo has hecho):
   composer require spatie/laravel-permission
   php artisan vendor:publish --provider="Spatie\\Permission\\PermissionServiceProvider"
   php artisan migrate

2) Añade el trait HasRoles en app/Models/User.php:
   use Spatie\\Permission\\Traits\\HasRoles;
   class User extends Authenticatable
   {
       use HasRoles;
       ...
   }

3) Copia los archivos de este ZIP a las rutas correspondientes en tu proyecto.

4) Añade las rutas (ejemplo) en routes/web.php:
   Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
       Route::resource('users', App\\Http\\Controllers\\Admin\\UserController::class);
   });

5) Ejecute el seeder de roles:
   php artisan db:seed --class=RolesSeeder

6) Crea un usuario admin y asígnale rol:
   php artisan tinker
   $u = App\\Models\\User::first();
   $u->assignRole('admin');

7) Accede a /admin/users (requiere login como admin).

Si quieres, yo puedo generar también:
- Las migraciones para añadir campos extra al usuario (telefono, estado)
- Un DataTable en la vista
- Validaciones más complejas
- Integración con Breeze UI

Fin.
