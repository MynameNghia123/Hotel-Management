<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceGroup extends Model
{
    protected $table = 'service_groups';
    public $timestamps = false; // Bảng này không có created_at, updated_at theo thiết kế hiện tại

    protected $fillable = [
        'service_name',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'group_id', 'id');
    }
}
