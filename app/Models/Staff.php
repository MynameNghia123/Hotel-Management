<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['first_name', 'last_name', 'password', 'phone_number', 'is_active', 'email', 'role_id'];
    // là whitelist, chỉ những trường này mới được phép gán hàng loạt (mass assignment)
    
    public $timestamps = false; // Tắt timestamps vì bảng staff không có created_at, updated_at
    
    public function role(){
        return $this->belongsTo(Role::class);
    }
}