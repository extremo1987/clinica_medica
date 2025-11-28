<?php
    namespace App\Models;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable {
        use HasFactory, Notifiable;

        protected $fillable = ['name','email','password'];

        protected $hidden = ['password','remember_token'];

        protected $casts = ['email_verified_at'=>'datetime'];

        public function roles(){ return $this->belongsToMany(Role::class,'role_user'); }

        public function hasRole($role){
            if(is_string($role)) return $this->roles->pluck('name')->contains($role);
            return (bool) $this->roles->intersect($role)->count();
        }

        public function hasPermission($permissionName){
            foreach($this->roles as $role){
                if($role->permissions->pluck('name')->contains($permissionName)) return true;
            }
            return false;
        }

        public function assignRole($role){
            if($role instanceof Role) $this->roles()->syncWithoutDetaching([$role->id]);
            elseif(is_numeric($role)) $this->roles()->syncWithoutDetaching([$role]);
            else {
                $r = Role::where('name',$role)->first();
                if($r) $this->roles()->syncWithoutDetaching([$r->id]);
            }
        }
    }
