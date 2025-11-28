<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /* =====================================
       LISTAR PERMISOS
    ====================================== */
    public function index()
    {
        $permissions = Permission::orderBy('label')->paginate(50);
        return view('permissions.index', compact('permissions'));
    }

    /* =====================================
       FORMULARIO CREAR
    ====================================== */
    public function create()
    {
        return view('permissions.create');
    }

    /* =====================================
       GUARDAR NUEVO PERMISO
    ====================================== */
    public function store(Request $r)
    {
        $r->validate([
            'name'  => 'required|unique:permissions,name',
            'label' => 'nullable|string'
        ]);

        Permission::create($r->only(['name', 'label']));

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permiso creado correctamente.');
    }

    /* =====================================
       FORMULARIO EDITAR
    ====================================== */
    public function edit($id)
    {
        $p = Permission::findOrFail($id);
        return view('permissions.edit', compact('p'));
    }

    /* =====================================
       ACTUALIZAR PERMISO
    ====================================== */
    public function update(Request $r, $id)
    {
        $p = Permission::findOrFail($id);

        $r->validate([
            'name'  => 'required|unique:permissions,name,' . $p->id,
            'label' => 'nullable|string'
        ]);

        $p->update($r->only(['name', 'label']));

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permiso actualizado correctamente.');
    }

    /* =====================================
       ELIMINAR PERMISO
    ====================================== */
    public function destroy($id)
    {
        $perm = Permission::findOrFail($id);

        // OPCIONAL: EVITAR BORRAR PERMISOS SENSIBLES
        if (in_array($perm->name, ['roles.manage', 'permissions.manage'])) {
            return back()->with('error', 'Este permiso no se puede eliminar.');
        }

        $perm->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permiso eliminado.');
    }
}
