
Módulo Usuarios + Roles y Permisos (Laravel 11) - Starter
--------------------------------------------------------
Contenido:
- Migrations (roles, permissions, role_user, permission_role)
- Models: Role, Permission, User (extensión)
- Controllers: UserController, RoleController, PermissionController
- Requests: StoreUserRequest, UpdateUserRequest
- Policies/Middleware: CheckPermission middleware
- Views (Blade) mínimas para listar/crear/editar usuarios y roles
- Seeder con usuario admin y roles/permissions básicos

Instrucciones:
1. Copia carpetas a tu proyecto Laravel (migrations, app/Models, app/Http/Controllers, resources/views/users, database/seeders).
2. Ejecuta `composer dump-autoload`
3. Ejecuta `php artisan migrate`
4. Ejecuta `php artisan db:seed --class=UsersRolesSeeder`
5. Ajusta `Auth` y Breeze si hace falta.
