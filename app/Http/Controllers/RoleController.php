<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /* =====================================
       LISTAR ROLES
    ====================================== */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(20);
        return view('roles.index', compact('roles'));
    }

    /* =====================================
       FORMULARIO CREAR
    ====================================== */
    public function create()
    {
        $permissions = Permission::orderBy('label')->get(); // mejor ordenados
        return view('roles.create', compact('permissions'));
    }

    /* =====================================
       GUARDAR NUEVO ROL
    ====================================== */
    public function store(Request $r)
    {
        $r->validate([
            'name'  => 'required|unique:roles,name',
            'label' => 'nullable|string'
        ]);

        $role = Role::create($r->only(['name', 'label']));

        // Asignar permisos si existen
        $role->permissions()->sync($r->permissions ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    /* =====================================
       FORMULARIO EDITAR
    ====================================== */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::orderBy('label')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    /* =====================================
       ACTUALIZAR ROL
    ====================================== */
    public function update(Request $r, $id)
    {
        $role = Role::findOrFail($id);

        $r->validate([
            'name'  => 'required|unique:roles,name,' . $role->id,
            'label' => 'nullable|string'
        ]);

        $role->update($r->only(['name', 'label']));

        // Actualizar permisos
        $role->permissions()->sync($r->permissions ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    /* =====================================
       ELIMINAR ROL
    ====================================== */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Opcional: evitar borrar rol admin
        if ($role->name === 'admin') {
            return back()->with('error', 'No se puede eliminar el rol administrador.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }

    /* =====================================
       EDITAR SOLO PERMISOS DEL ROL
    ====================================== */
    public function editPermissions(Role $role)
    {
        $permissions = Permission::orderBy('label')->get();

        return view('roles.permissions', compact('role', 'permissions'));
    }

    /* =====================================
       GUARDAR PERMISOS DEL ROL
    ====================================== */
    public function updatePermissions(Request $r, Role $role)
    {
        $role->permissions()->sync($r->permissions ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Permisos del rol actualizados correctamente.');
    }
}
