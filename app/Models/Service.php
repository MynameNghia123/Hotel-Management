<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'group_id',
        'unit_price',
        'unit'
    ];

    public function group()
    {
        return $this->belongsTo(ServiceGroup::class, 'group_id', 'id');
    }
}
