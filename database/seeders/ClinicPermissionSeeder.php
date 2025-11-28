<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class ClinicPermissionSeeder extends Seeder
{
    public function run()
    {
        // --------------------------------------------------------------
        // LISTA DE PERMISOS POR MÓDULOS
        // --------------------------------------------------------------
        $permisos = [

            // =========================
            // USUARIOS
            // =========================
            ['name' => 'usuarios.view',   'label' => 'Ver usuarios'],
            ['name' => 'usuarios.create', 'label' => 'Crear usuarios'],
            ['name' => 'usuarios.edit',   'label' => 'Editar usuarios'],
            ['name' => 'usuarios.delete', 'label' => 'Eliminar usuarios'],

            // =========================
            // PACIENTES
            // =========================
            ['name' => 'pacientes.view',   'label' => 'Ver pacientes'],
            ['name' => 'pacientes.create', 'label' => 'Registrar pacientes'],
            ['name' => 'pacientes.edit',   'label' => 'Editar pacientes'],
            ['name' => 'pacientes.delete', 'label' => 'Eliminar pacientes'],

            // =========================
            // CONSULTAS
            // =========================
            ['name' => 'consultas.view',   'label' => 'Ver consultas'],
            ['name' => 'consultas.create', 'label' => 'Crear consultas'],
            ['name' => 'consultas.edit',   'label' => 'Editar consultas'],
            ['name' => 'consultas.delete', 'label' => 'Eliminar consultas'],

            // =========================
            // SIGNOS VITALES
            // =========================
            ['name' => 'signos.view',   'label' => 'Ver signos vitales'],
            ['name' => 'signos.create', 'label' => 'Registrar signos vitales'],
            ['name' => 'signos.edit',   'label' => 'Editar signos vitales'],

            // =========================
            // EXÁMENES
            // =========================
            ['name' => 'examenes.view',   'label' => 'Ver exámenes'],
            ['name' => 'examenes.subir',  'label' => 'Subir resultados de exámenes'],
            ['name' => 'examenes.delete', 'label' => 'Eliminar resultados'],

            // =========================
            // CAJA / COBROS
            // =========================
            ['name' => 'caja.view',   'label' => 'Ver pagos y cobros'],
            ['name' => 'caja.create', 'label' => 'Registrar cobro de consulta'],

            // =========================
            // REPORTES
            // =========================
            ['name' => 'reportes.view', 'label' => 'Ver reportes del sistema'],

            // =========================
            // CONFIGURACIÓN DEL SISTEMA
            // =========================
            ['name' => 'roles.view',       'label' => 'Ver roles'],
            ['name' => 'roles.manage',     'label' => 'Administrar roles'],
            ['name' => 'permissions.view', 'label' => 'Ver permisos'],
            ['name' => 'permissions.manage', 'label' => 'Administrar permisos'],
        ];

        // --------------------------------------------------------------
        // CREAR PERMISOS SI NO EXISTEN
        // --------------------------------------------------------------
        foreach ($permisos as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                ['label' => $perm['label']]
            );
        }

        // --------------------------------------------------------------
        // CREAR ROLES PRINCIPALES
        // --------------------------------------------------------------
        $admin = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrador']);
        $doctor = Role::firstOrCreate(['name' => 'doctor'], ['label' => 'Médico']);
        $secretaria = Role::firstOrCreate(['name' => 'secretaria'], ['label' => 'Secretaria']);

        // --------------------------------------------------------------
        // ASIGNAR TODOS LOS PERMISOS AL ADMINISTRADOR
        // --------------------------------------------------------------
        $admin->permissions()->sync(Permission::all()->pluck('id'));

        // --------------------------------------------------------------
        // PERMISOS BÁSICOS PARA MÉDICO
        // --------------------------------------------------------------
        $doctor->permissions()->sync(
            Permission::whereIn('name', [
                'pacientes.view',
                'pacientes.create',
                'consultas.view',
                'consultas.create',
                'consultas.edit',
                'signos.view',
                'signos.create',
                'examenes.view',
                'examenes.subir',
                'reportes.view',
            ])->pluck('id')
        );

        // --------------------------------------------------------------
        // PERMISOS PARA SECRETARIA
        // --------------------------------------------------------------
        $secretaria->permissions()->sync(
            Permission::whereIn('name', [
                'pacientes.view',
                'pacientes.create',
                'caja.view',
                'caja.create',
                'reportes.view',
            ])->pluck('id')
        );
    }
}
