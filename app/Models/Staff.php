<?php

namespace App\Models;

use App\Traits\HasRolePermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasRolePermissions;

    protected $fillable = ['first_name', 'last_name', 'password', 'phone_number', 'is_active', 'email', 'role_id'];

    public $timestamps = false;

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
