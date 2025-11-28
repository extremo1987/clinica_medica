<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'label'];

    /** Usuarios relacionados */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /** Permisos relacionados */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /** Asignar permiso al rol */
    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        if ($permission) {
            $this->permissions()->syncWithoutDetaching([$permission->id]);
        }
    }
}
