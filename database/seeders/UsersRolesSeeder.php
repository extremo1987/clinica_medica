<?php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\DB;
    use App\Models\User;
    use App\Models\Role;
    use App\Models\Permission;

    class UsersRolesSeeder extends Seeder {
        public function run(): void {
            // permisos básicos
            $perms = [
                ['name'=>'manage_users','label'=>'Gestionar usuarios'],
                ['name'=>'manage_roles','label'=>'Gestionar roles'],
                ['name'=>'manage_permissions','label'=>'Gestionar permisos'],
            ];
            foreach($perms as $p) Permission::firstOrCreate(['name'=>$p['name']], ['label'=>$p['label']]);

            $adminRole = Role::firstOrCreate(['name'=>'admin'], ['label'=>'Administrador']);
            $doctorRole = Role::firstOrCreate(['name'=>'doctor'], ['label'=>'Doctor']);

            // asignar permisos admin
            $adminRole->permissions()->sync(Permission::pluck('id')->toArray());

            // crear usuario admin
            $admin = User::firstOrCreate(['email'=>'admin@example.com'], [
                'name'=>'Admin','password'=>Hash::make('password')
            ]);
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
