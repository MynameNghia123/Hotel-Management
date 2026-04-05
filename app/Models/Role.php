<?php
namespace App\Models;
use App\Models\RoleClaim;
use Illuminate\Database\Eloquent\Model;

    class Role extends Model{
        protected $fillable = ['name'];

        public function roleClaims(){
            return $this->hasMany(RoleClaim::class);
        }
    }
?>