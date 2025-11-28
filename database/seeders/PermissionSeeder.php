<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            ['name' => 'users.view',   'label' => 'Ver usuarios'],
            ['name' => 'users.create', 'label' => 'Crear usuarios'],
            ['name' => 'users.edit',   'label' => 'Editar usuarios'],
            ['name' => 'users.delete', 'label' => 'Eliminar usuarios'],
        ];

        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p['name']], $p);
        }
    }
}
