<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin','doctor','recepcion','laboratorio','contabilidad'];
        foreach($roles as $r) {
            if(Role::where('name',$r)->count()==0) Role::create(['name'=>$r]);
        }
    }
}
