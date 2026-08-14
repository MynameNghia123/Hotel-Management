<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleClaim extends Model
{
    protected $fillable = ['claim_name', 'claim_value', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
